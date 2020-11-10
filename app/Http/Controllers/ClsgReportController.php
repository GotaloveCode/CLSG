<?php

namespace App\Http\Controllers;

use App\Http\Resources\PerformaceScoreResource;
use App\Http\Resources\WspReportingResource;
use App\Models\PerformanceScore;
use App\Models\WspReporting;
use App\Models\CslgCalculation;
use Illuminate\Http\Request;
use App\Http\Resources\CslgResource;
use Yajra\DataTables\Facades\DataTables;


class ClsgReportController extends Controller
{

    public function index()
    {
        if (!request()->ajax()) {
            return view('checklists.cslg.index');
        }
        $wsp = auth()->user()->wsps()->first();

        if ($wsp) {
            if ($wsp->bcp) {
                $reporting = CslgCalculation::where('bcp_id', $wsp->bcp->id)->get();
            } else {
                $reporting = [];
            }
        } else {
            $reporting = CslgCalculation::get();
        }

        $reporting = CslgResource::collection($reporting);

        return Datatables::of($reporting)
            ->addColumn('action', function ($reporting) {
                return '<a href="' . route("cslg-calculation.show", $reporting['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);
    }


    public function create()
    {
        $wsp = auth()->user()->wsps()->first();
        $bcp = $wsp->bcp;
        $bcp_id = $bcp->id;
        $exiting_cslg = CslgCalculation::where('bcp_id', $bcp_id)
            ->latest()
            ->first();;
        $exiting_cslg ? $cslg = json_encode(new CslgResource($exiting_cslg)) : $cslg = json_encode([]);

        $operations = WspReporting::where('bcp_id', $bcp_id)->latest()->first();

        if (!$operations) return redirect()->back()->with('success', 'Please ensure you have created WSP Reporting first');

        $mgm = $bcp->mgms()
            ->where('month', $operations->month)
            ->where('year', $operations->year)
            ->first();

        $operations = json_encode(new WspReportingResource($operations));

        if (!$mgm) return redirect()->back()->with('success', 'Please ensure the Monthly Grant Multiplier for the month is set on the BCP');

        $grant = floatval($mgm->amount);

        $exiting_score = PerformanceScore::where('bcp_id', $bcp_id)->latest()->first();
        $exiting_score ? $score = json_encode(new PerformaceScoreResource($exiting_score)) : $score = json_encode([]);
        $score = json_decode($score);
        if (!empty($score)) {
            $score = intval($score->total);
        } else {
            $score = 0;
        }
        return view("checklists.cslg.create", compact("cslg", "operations", 'grant', 'score'));
    }

    public function show(CslgCalculation $cslg_calculation)
    {
        return view("checklists.cslg.show", compact("cslg_calculation"));
    }

    public function approveCslg(Request $request)
    {
        CslgCalculation::find($request->input("id"))->update($request->except(['month', 'wsp']));
        return response()->json('success');
    }

}
