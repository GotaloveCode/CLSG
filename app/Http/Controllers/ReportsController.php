<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\BcpChecklist;
use App\Models\BcpMonthlyReport;
use App\Models\MonthlyVerification;
use App\Models\MonthlyVerificationReport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use \App\Exports\InvoicesExport;
use App\Http\Resources\BcpChecklistResource;
use App\Http\Resources\VerificationResource;


class ReportsController extends Controller
{

    public function index(){
     return view("checklists.index");
    }
    public function monthlyVerification(){
     return view("verification.index");
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
       $bcp = BcpMonthlyReport::create([
            'essential'=>json_encode($request->input("essential")),
            'customer'=>json_encode($request->input("customer")),
            'staff'=>json_encode($request->input("staff")),
            'communication'=>json_encode($request->input("communication")),
            'month' =>   $request->input("month"),
            'year' =>   $request->input("year"),
        ]);
       return response()->json($bcp);
    }
    public function saveVerification(Request $request)
    {
       $verification = MonthlyVerificationReport::create([
            'performance_score_details'=>json_encode($request->input("performance_score_details")),
            'clsg_details'=>json_encode($request->input("clsg_details")),
            'wsp'=> $request->input("wsp"),
            'recommendations'=> $request->input("recommendations"),
            'verification_period'=> $request->input("verification_period"),
            'verification_team'=>$request->input("verification_team"),
            'month' =>   $request->input("month"),
            'year' =>   $request->input("year"),
        ]);
       return response()->json($verification);
    }

    public function getChecklist(Request $request)
    {
        $bcp = BcpMonthlyReport::where("month",$request->get("month"))->where("year",$request->get("year"))->first();
       if ($bcp) $bcp = new BcpChecklistResource($bcp);
       else $bcp = [];
        return response()->json($bcp);
    }
    public function getVerification(Request $request)
    {
        $verification = MonthlyVerificationReport::where("month",$request->get("month"))->where("year",$request->get("year"))->first();
       if ($verification) $verification = new VerificationResource($verification);
       else $verification = [];
        return response()->json($verification);
    }
}
