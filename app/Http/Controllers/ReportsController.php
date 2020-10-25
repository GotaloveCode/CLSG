<?php

namespace App\Http\Controllers;


use App\Http\Requests\MonthlyVerificationRequest;
use App\Models\BcpChecklist;
use App\Models\BcpMonthlyReport;
use App\Models\MonthlyVerification;
use App\Models\MonthlyVerificationReport;
use App\Models\Wsp;
use Illuminate\Http\Request;
use App\Http\Resources\BcpChecklistResource;
use App\Http\Resources\VerificationResource;


class ReportsController extends Controller
{

    public function index()
    {
        return view("checklists.index");
    }

    public function monthlyVerification()
    {
        $wsps = Wsp::select('id','name')->get();
        return view("verification.index")->with(compact('wsps'));
    }

    public function checklist()
    {
        return response()->json(BcpChecklist::all());
    }

    public function score()
    {
        return response()->json(MonthlyVerification::all());
    }

    public function saveChecklist(Request $request)
    {
        $bcp = auth()->user()->wsps()->first()->bcp;

        if($bcp->id != $request->input("bcp_id")){
            return response()->json([
                'message' => 'The given field was invalid',
                'errors' => ['bcp_id' => ['The BCP does not belong to the WSP!']]
            ], 422);
        }

        $bcp = BcpMonthlyReport::where('month',$request->input("month"))
            ->where('year', $request->input("year"))
            ->where('bcp_id', $request->input("bcp_id"))
            ->first();

        if($bcp){
            return response()->json([
                'message' => 'The given field was invalid',
                'errors' => ['month' => ['A BCP Monthly report already exists for this month!']]
            ], 422);
        }

        $bcp = BcpMonthlyReport::create([
            'essential' => json_encode($request->input("essential")),
            'customer' => json_encode($request->input("customer")),
            'staff' => json_encode($request->input("staff")),
            'communication' => json_encode($request->input("communication")),
            'bcp_id' => $request->input("bcp_id"),
            'month' => $request->input("month"),
            'year' => $request->input("year"),
        ]);
        return response()->json($bcp);
    }

    public function saveVerification(MonthlyVerificationRequest $request)
    {
        $verification = MonthlyVerificationReport::where('month',$request->input("month"))
            ->where('year', $request->input("year"))
            ->where('wsp_id', $request->input("wsp_id"))
            ->first();

        if($verification){
            return response()->json([
                'message' => 'The given field was invalid',
                'errors' => ['month' => ['A Monthly Performance Verification Report for this WSP already exists for this period!']]
            ], 422);
        }
        $verification = MonthlyVerificationReport::create([
            'performance_score_details' => json_encode($request->input("performance_score_details")),
            'clsg_details' => json_encode($request->input("clsg_details")),
            'wsp_id' => $request->input("wsp_id"),
            'recommendations' => $request->input("recommendations"),
            'verification_team' => $request->input("verification_team"),
            'month' => $request->input("month"),
            'year' => $request->input("year"),
        ]);
        return response()->json($verification);
    }

    public function getChecklist(Request $request)
    {
        $bcp = BcpMonthlyReport::where("month", $request->get("month"))->where("year", $request->get("year"))->first();
        if ($bcp) $bcp = new BcpChecklistResource($bcp);
        else $bcp = [];
        return response()->json($bcp);
    }

    public function getVerification(Request $request)
    {
        $verification = MonthlyVerificationReport::where("month", $request->get("month"))->where("year", $request->get("year"))->first();
        if ($verification) $verification = new VerificationResource($verification);
        else $verification = [];
        return response()->json($verification);
    }
}
