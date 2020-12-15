<?php

namespace App\Http\Controllers;

use App\Http\Requests\ErpRequest;
use App\Http\Resources\ErpResource;
use App\Models\Approval;
use App\Models\Erp;
use App\Models\Mitigation;
use App\Models\Operationcost;
use App\Models\Risk;
use App\Models\Service;
use App\Traits\ErpAuthTrait;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\SendMailNotification;
use PDF;

class ErpController extends Controller
{
    use ErpAuthTrait, SendMailNotification;

    public function index()
    {
        if (!request()->ajax()) {
            return view('erps.index');
        }
        $erps = Erp::query()->with('wsp:id,name')->select('erps.*');

        return Datatables::of($erps)
            ->addColumn('action', function ($erp) {
                return '<a href="' . route("erps.show", $erp->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Review</a>';
            })
            ->make(true);
    }

    public function reviewerList()
    {
        if (!request()->ajax()) {
            return view('erps.list');
        }

        $ids = Approval::query()->where('user_id',auth()->id())
            ->where('approvable_type','App\\Models\\Erp')
            ->pluck('approvable_id');

        $erps = Erp::whereIn('erps.id',$ids)->with('wsp:id,name')->select('erps.*');

        return Datatables::of($erps)
            ->addColumn('action', function ($erp) {
                return '<a href="' . route("erps.show", $erp->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Review</a>';
            })
            ->make(true);
    }


    public function create()
    {
        $wsp = auth()->user()->wsps()->first();
        if (!isset($wsp->eoi) || $wsp->eoi->status !== "WSTF Approved") {
            return redirect(route("eois.create"))->withErrors('Expression of Interest first must be submitted to and approved by WSTF');
        }
        $interventions = $wsp->eoi->estimatedcosts;
        $eoiOperations = $wsp->eoi->operationCosts;
        $staff = $wsp->staff()->selectRaw("CONCAT(firstname,' ',lastname) as name,id,type")->get();
        $erp_load = $wsp->erp;
        $operationCosts = Cache::rememberForever('operationCosts', function () {
            return Operationcost::select('id', 'name')->get();
        });
        $services = Cache::rememberForever('services', function () {
            return Service::select('id', 'name')->get();
        });

        $risks = Cache::rememberForever('risks', function () {
            return Risk::pluck('name');
        });

        $mitigation = Cache::rememberForever('mitigation', function () {
            return Mitigation::pluck('name');
        });

        $services = $services->pluck('name');

        if ($erp_load) $erp_load = json_encode(new ErpResource($erp_load));

        return view('erps.create')->with(compact('interventions', 'staff','risks', 'mitigation', 'services', 'eoiOperations', 'erp_load', 'operationCosts'));
    }

    public function store(ErpRequest $request)
    {
        $erp = Erp::create($request->only(['wsp_id', 'coordinator']));
        $this->createErpRelations($erp, $request);
        SendMailNotification::postReview($erp->status, $erp->wsp_id, route('erps.show', $erp->id), $erp->wsp->name . ' ERP Created');

        if ($request->ajax()) {
            return response()->json($erp);
        }
        return back()->with(['erp' => $erp]);
    }


    public function show(Erp $erp)
    {
        $progress = $erp->progress();
        $eoi = $erp->wsp->first()->eoi;
        $erp = $erp->load(['wsp', 'erp_items', 'attachments','approvals','approvals.user']);
        if (\request()->has('print')) {
            $pdf = \PDF::loadView('erps.print', $erp);
            return $pdf->inline();
        }
        return view('erps.show')->with(compact('erp', 'progress', 'eoi'));
    }


    public function update(ErpRequest $request, Erp $erp)
    {
        if ($erp->status == "WSTF Approved") {
            return response()->json([
                'message' => 'The ERP has already been approved by WSFT no further changes can be made',
                'errors' => ['wsp_id' => ['The ERP has already been approved by WSFT no further changes can be made!']]
            ], 422);
        }

        $erp->update($request->validated() + ['status' => 'Pending']);
        $erp->erp_items()->delete();
        $erp->operationcosts()->detach();
        $this->createErpRelations($erp, $request);
        SendMailNotification::postReview($erp->status, $erp->wsp_id, route('erps.show', $erp->id), $erp->wsp->name . ' ERP Updated');
        if ($request->ajax()) {
            return response()->json($erp);
        }
        return back()->with(['erp' => $erp]);
    }

    private function createErpRelations(Erp $erp, Request $request)
    {
        foreach ($request->input('items') as $item) {
            $risk = $item['risks'];
            if($risk == 'Other'){
                $risk = $item['other_risk'];
            }
            $mitigiation = [];
            foreach ($item['mitigation'] as $m){
                $m == 'Other' ? $m = $item['other_mitigation'] : $m;
                $mitigiation[] = $m;
            }

            $erp->erp_items()->create([
                'emergency_intervention' => $item['emergency_intervention'],
                'risks' => $risk,
                'mitigation' => $mitigiation,
                'cost' => $item['cost'],
                'other' => $item['other'],
            ]);
        }

        foreach ($request->input('operation_costs') as $operation_cost) {
            $erp->operationcosts()->attach($operation_cost['operationcost_id'], [
                'cost' => $operation_cost['cost']
            ]);
        }
    }


    public function review(Erp $erp, Request $request)
    {
        $this->canAccessErp($erp);
        $erp->status = $request->status;
        $erp->save();

        $route = route('erps.show', $erp->id);
        SendMailNotification::postReview($request->status, $erp->wsp_id, $route, $erp->wsp->name . ' ERP Review');

        return response()->json([
            'message' => 'ERP status changed to ' . $request->status,
            'route' => $route
        ]);
    }

    public function comment(Erp $erp, CommentRequest $request)
    {
        $this->canAccessErp($erp);

        $erp->comments()->create([
            'description' => $request->description,
            'user_id' => auth()->id()
        ]);

        $route = route('erps.show', $erp->id);
        SendMailNotification::postComment($request->description, $erp->status, $erp->wsp_id, $route, $erp->wsp->name . ' ERP Comment');

        return response()->json(['message' => 'Comment posted successfully']);
    }

    public function approver(Erp $erp)
    {
        $this->canAccessErp($erp);
        $hasApproval = $erp->approvals()
                ->where('user_id', auth()->id())
                ->count() > 0;

        if($hasApproval){
            return response()->json(['message' => 'Reviewer already assigned!']);
        }

        $erp->approvals()->create([
            'user_id' => auth()->id()
        ]);

        return response()->json(['message' => 'Reviewer assignment successful!']);
    }
}
