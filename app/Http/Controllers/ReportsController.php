<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\BcpChecklist;
use App\Models\BcpMonthlyReport;
use App\Models\MonthlyVerification;
use App\Models\MonthlyVerificationReport;
use App\Models\ReportingFormart;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use \App\Exports\InvoicesExport;
use App\Http\Resources\BcpChecklistResource;
use App\Http\Resources\VerificationResource;
use App\Http\Resources\ReportingFormatResource;


class ReportsController extends Controller
{

    public function index(){
     return view("checklists.index");
    }
    public function monthlyVerification(){
     return view("verification.index");
    }
     public function monthlyReportFormat(){
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
    public function reportFormat()
    {
    return response()->json(ReportingFormart::all());
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
    public function saveFormat(Request $request)
    {
       $format = MonthlyReportingFormat::create([
            'wsp'=>$request->input("wsp"),
            'reporting_period'=>$request->input("reporting_period"),
            'bcp_status_implementation'=> $request->input("bcp_status_implementation"),
            'covid_status_implementation'=> $request->input("covid_status_implementation"),
            'revenues_collected'=> $request->input("revenues_collected"),
            'o_m_costs'=>$request->input("o_m_costs"),
            'resolution_status'=>$request->input("resolution_status"),
            'challenges'=>$request->input("challenges"),
            'expected_activities_next_month'=>$request->input("expected_activities_next_month"),
            'achievement_details'=> json_encode($request->input("achievement_details")),
            'list_of_evidence_details'=> json_encode($request->input("list_of_evidence_details")),
            'month' =>   $request->input("month"),
            'year' =>   $request->input("year"),
        ]);
       return response()->json($format);
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
    public function getFormat(Request $request)
    {
        $format = MonthlyVerificationReport::where("month",$request->get("month"))->where("year",$request->get("year"))->first();
       if ($format) $format = new ReportingFormatResource($format);
       else $format = [];
        return response()->json($format);
    }
}
