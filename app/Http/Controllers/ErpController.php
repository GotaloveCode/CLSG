<?php

namespace App\Http\Controllers;

use App\Http\Requests\ErpRequest;
use App\Models\Erp;
use App\Traits\ErpAuthTrait;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\SendMailNotification;

class ErpController extends Controller
{
    use ErpAuthTrait,SendMailNotification;

    public function index()
    {
        if (!request()->ajax()) {
            return view('erps.index');
        }
        $erps = Erp::query()->with('wsp:id,name');
        if(auth()->user()->hasRole('wsp')){
            $erps = $erps->where('wsp_id', auth()->user()->wsps()->first()->id);
        }
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
        $wsp_id = $wsp->id;
        return view('erps.create')->with(compact('interventions', 'wsp_id'));
    }

    public function store(ErpRequest $request)
    {
        $erp = Erp::create($request->only(['wsp_id', 'coordinator']));
        foreach ($request->input('items') as $item) {
            $erp->erp_items()->create([
                'emergency_intervention' => $item['emergency_intervention'],
                'risks' => $item['risks'],
                'mitigation' => $item['mitigation'],
                'cost' => $item['cost'],
                'other' => $item['other'],
            ]);
        }
        if ($request->ajax()) {
            return response()->json(['message' => 'ERP created successfully']);
        }
        return back()->with(['eoi' => $erp]);
    }


    public function show(Erp $erp)
    {
        $progress = $erp->progress();
        $eoi = $erp->wsp->first()->eoi;
        $erp = $erp->load(['wsp', 'erp_items']);
        return view('erps.show')->with(compact('erp', 'progress', 'eoi'));
    }


    public function update(ErpRequest $request, Erp $erp)
    {

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
