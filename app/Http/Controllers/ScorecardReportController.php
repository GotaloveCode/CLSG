<?php

namespace App\Http\Controllers;

use App\Http\Resources\PerformaceScoreResource;
use App\Models\PerformanceScore;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ScorecardReportController extends Controller
{

    public function index()
    {
        if (!request()->ajax()) {
            return view('checklists.performance.list');
        }
        $wsp = auth()->user()->wsps()->first();

        if ($wsp) {
            if ($wsp->bcp) {
                $score = PerformanceScore::where('bcp_id', $wsp->bcp->id)->get();
            } else {
                $score = [];
            }
        } else {
            $score = PerformanceScore::get();
        }
        $score = PerformaceScoreResource::collection($score);

        return Datatables::of($score)
            ->addColumn('action', function ($score) {
                return '<a href="' . route("performance-score-card.show", $score['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|in:' . now()->year,
            'month' => 'required|in:' . now()->month . ',' . (now()->month - 1),
        ]);

        $request['month'] = $request->month;
        $request['year'] = $request->year;
        $request['bcp_id'] = auth()->user()->wsps()->first()->bcp->first()->id;
        $score = PerformanceScore::create($request->all());
        return response()->json($score);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
