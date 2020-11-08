<?php

namespace App\Http\Controllers;

use App\Http\Resources\PerformaceScoreResource;
use App\Models\PerformanceScore;
use App\Models\WspReporting;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ScoreCardReportController extends Controller
{

    public function index()
    {
        if (!request()->ajax()) {
            return view('checklists.performance.index');
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
        $bcp_id = auth()->user()->wsps()->first()->bcp->id;
        $exiting_score = PerformanceScore::where('bcp_id', $bcp_id)->latest()->first();
        $exiting_score ? $score = json_encode(new PerformaceScoreResource($exiting_score)) : $score = json_encode([]);
        $wsp = WspReporting::where('bcp_id', $bcp_id)->latest()->first();
        if (!$wsp) return redirect()->back()->with("success", "Please ensure you have have filled in the monthly wsp form first");
        return view("checklists.performance.create", compact("score"));
    }


    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|in:' . now()->year,
            'month' => 'required|in:' . now()->month . ',' . (now()->month - 1),
        ]);

        $request['month'] = $request->month;
        $request['year'] = $request->year;
        $request['bcp_id'] = auth()->user()->wsps()->first()->bcp->id;
        $score = PerformanceScore::create($request->all());
        return response()->json($score);
    }

    public function show(PerformanceScore $performance_score_card)
    {
        if (\request()->has('print')) {
            $score = $performance_score_card;
            $pdf = \PDF::loadView('checklists.performance.print', compact('score'));
            return $pdf->inline();
        }

        $score = json_encode(new PerformaceScoreResource($performance_score_card));
        return view("checklists.performance.show", compact("score","performance_score_card"));
    }



    public function update(Request $request, PerformanceScore $performance_score_card)
    {
        $request['status'] = 'Pending';
        $performance_score_card->update($request->except('month','year','wsp','total'));
        return response()->json($performance_score_card);
    }


}
