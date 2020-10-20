<?php

namespace App\Http\Controllers;

use App\Http\Requests\ErpRequest;
use App\Models\Erp;
use App\Traits\ErpAuthTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ErpController extends Controller
{
    use ErpAuthTrait;

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
                return '<a href="' . route("erps.index", $erp->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Review</a>';
            })
            ->make(true);
    }


    public function create()
    {
        $wsp = auth()->user()->wsps()->first();
        if (!$wsp->eoi) {
            abort('403', 'Create Expression of Interest first');
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
        $this->canAccessErp($erp);
    }


    public function update(ErpRequest $request, Erp $erp)
    {

    }


}
