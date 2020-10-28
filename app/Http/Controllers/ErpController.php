<?php

namespace App\Http\Controllers;

use App\Http\Requests\ErpRequest;
use App\Http\Resources\ErpResource;
use App\Models\Erp;
use App\Models\Operationcost;
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
        $erps = Erp::query()->with('wsp:id,name');

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

        $erp_load = $wsp->erp;
        $operationCosts = Cache::rememberForever('operationCosts', function () {
            return Operationcost::select('id', 'name')->get();
        });

        if ($erp_load) $erp_load = json_encode(new ErpResource($erp_load));

        return view('erps.create')->with(compact('interventions','eoiOperations', 'erp_load', 'operationCosts'));
    }

    public function store(ErpRequest $request)
    {
        $erp = Erp::create($request->only(['wsp_id', 'coordinator']));
        $this->createErpRelations($erp, $request);
        SendMailNotification::postReview($erp->status, $erp->wsp_id, route('erps.show', $erp->id), $erp->wsp->name . ' ERP Created');

        if ($request->ajax()) {
            return response()->json(['message' => 'ERP created successfully']);
        }
        return back()->with(['eoi' => $erp]);
    }


    public function show(Erp $erp)
    {
        $progress = $erp->progress();
        $eoi = $erp->wsp->first()->eoi;
        $erp = $erp->load(['wsp', 'erp_items', 'attachments']);
        if (\request()->has('print')) {
            $pdf = PDF::loadView('erps.print', $erp);
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
        $this->createErpRelations($erp, $request);
        SendMailNotification::postReview($erp->status, $erp->wsp_id, route('erps.show', $erp->id), $erp->wsp->name . ' ERP Updated');
        if ($request->ajax()) {
            return response()->json(['message' => 'Emergency Response Plan updated successfully']);
        }
        return back()->with('success', 'Emergency Response Plan updated successfully');
    }

    private function createErpRelations(Erp $erp, Request $request)
    {
        foreach ($request->input('items') as $item) {
            $erp->erp_items()->create([
                'emergency_intervention' => $item['emergency_intervention'],
                'risks' => $item['risks'],
                'mitigation' => $item['mitigation'],
                'cost' => $item['cost'],
                'other' => $item['other'],
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
}
