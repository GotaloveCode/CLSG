<?php

namespace App\Http\Controllers;

use App\Models\Erp;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ErpController extends Controller
{

    public function index()
    {
        if (!request()->ajax()) {
            return view('erps.index');
        }
        return Datatables::of(Erp::query()->with('wsp:name'))
            ->addColumn('action', function ($erp) {
                return '<a href="' . route("eoi.preview", $erp->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Review</a>';
            })
            ->make(true);
    }


    public function create()
    {
        $wsp = auth()->user()->wsps()->first();
        if(!$wsp->eoi){
            abort('403','Create Expression of Interest first');
        }
        $interventions = $wsp->eoi->estimatedcosts;
        return view('erps.create')->with(compact('interventions'));
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Erp  $erp
     * @return \Illuminate\Http\Response
     */
    public function show(Erp $erp)
    {
        //
    }


    public function update(Request $request, Erp $erp)
    {
        //
    }


}
