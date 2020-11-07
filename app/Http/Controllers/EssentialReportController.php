<?php

namespace App\Http\Controllers;

use App\Http\Resources\EssentialReportResource;
use App\Http\Resources\VulnerableCustomerResource;
use App\Models\BcpChecklist;
use App\Models\EssentialOperationReport;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EssentialReportController extends Controller
{

    public function index()
    {
        if (!request()->ajax()) {
            return view('checklists.essential.index');
        }

        $wsp = auth()->user()->wsps()->first();

        if ($wsp) {
            if ($wsp->bcp) {
                $essential = EssentialOperationReport::where('bcp_id', $wsp->bcp->id)->get();
            } else {
                $essential = [];
            }
        } else {
            $essential = EssentialOperationReport::get();
        }

        $essential = EssentialReportResource::collection($essential);

        return Datatables::of($essential)
            ->addColumn('action', function ($essential) {
                return '<a href="' . route("essential-operation.show", $essential['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);
    }


    public function create()
    {
        $exiting_essential = EssentialOperationReport::where('bcp_id', auth()->user()->wsps()->first()->bcp->id)->latest()->first();
        $exiting_essential ? $essential_item = json_encode(new VulnerableCustomerResource($exiting_essential)) : $essential_item = json_encode([]);
        $items = json_encode(BcpChecklist::all());

        return view("checklists.essential.create", compact("items", "essential_item"));
    }


    public function store(Request $request)
    {
        $format = EssentialOperationReport::create([
            'bcp_id' => auth()->user()->wsps()->first()->bcp->first()->id,
            'details' => json_encode($request->input("details")),
            'month' => $this->getMonth(),
            'year' => $this->getYear(),
        ]);
        return response()->json($format);
    }


    public function show($id)
    {
        $essential = json_encode(new EssentialReportResource(EssentialOperationReport::find($id)));
        $items = json_encode(BcpChecklist::all());
        return view("checklists.essential.show", compact("essential", "items"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
