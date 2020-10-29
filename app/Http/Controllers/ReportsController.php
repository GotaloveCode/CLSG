<?php

namespace App\Http\Controllers;


use App\Http\Requests\BcpMonthlyReportRequest;
use App\Http\Requests\MonthlyVerificationRequest;
use App\Models\BcpChecklist;
use App\Models\BcpMonthlyReport;
use App\Models\MonthlyVerification;
use App\Models\MonthlyVerificationReport;
use App\Models\ReportingFormart;
use App\Models\MonthlyReportingFormat;
use App\Models\Wsp;
use Illuminate\Http\Request;
use App\Http\Resources\BcpChecklistResource;
use App\Http\Resources\VerificationResource;
use App\Http\Resources\ReportingFormatResource;
use Yajra\DataTables\Facades\DataTables;


class ReportsController extends Controller
{

    public function index()
    {
        return view("checklists.index");
    }

    public function monthlyVerification()
    {
        $wsps = Wsp::select('id', 'name')->get();
        return view("verification.index")->with(compact('wsps'));
    }
    public function monthlyChecklist()
    {
        return view("checklists.index");
    }
    public function verificationIndex()
    {
        if (!request()->ajax()) {
            return view('verification.list');
        }
        $verify = MonthlyVerificationReport::query()->with('wsp:id,name')->select('monthly_verification_reports.*');


        return Datatables::of($verify)
            ->addColumn('action', function ($verify) {
                return '<a href="' . route("verification.show", $verify->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);

    }
    public function checklistIndex()
    {
        if (!request()->ajax()) {
            return view('checklists.list');
        }
        $checklist = BcpChecklistResource::collection(BcpMonthlyReport::get());

        return Datatables::of($checklist)
            ->addColumn('action', function ($checklist) {
                //  dd($checklist);
                return '<a href="' . route("checklist.show", $checklist['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);

    }
    public function formatIndex()
    {
        if (!request()->ajax()) {
            return view('formats.list');
        }
        $format = ReportingFormatResource::collection(MonthlyReportingFormat::get());

        return Datatables::of($format)
            ->addColumn('action', function ($format) {
                return '<a href="' . route("report-format.show", $format['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);

    }

    public function monthlyReportFormat(){
        return view("formats.index");

    }

    public function showVerification($id)
    {
        $verify = json_encode(new VerificationResource(MonthlyVerificationReport    ::find($id)));
        $checklist_items = json_encode(MonthlyVerification::all());
        return view("verification.show",compact("verify","checklist_items"));
    }

    public function showChecklist($id)
    {
        $checklist = json_encode(new BcpChecklistResource(BcpMonthlyReport::find($id)));
        $checklist_items = json_encode(BcpChecklist::all());
        return view("checklists.show",compact("checklist","checklist_items"));
    }
    public function showFormat($id)
    {
        $format = json_encode(new ReportingFormatResource(MonthlyReportingFormat::find($id)));
        $items = json_encode(ReportingFormart::all());
        return view("formats.show",compact("format","items"));
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

    public function saveChecklist(BcpMonthlyReportRequest $request)
    {

        $bcp = BcpMonthlyReport::where('month', $request->input("month"))
            ->where('year', $request->input("year"))
            ->where('bcp_id', auth()->user()->wsps()->first()->bcp->first()->id)
            ->first();

        if ($bcp) {
            return response()->json([
                'message' => 'The given field was invalid',
                'errors' => ['month' => ['A BCP Monthly report already exists for this month!']]
            ], 422);
        }

        $bcp = BcpMonthlyReport::create([
            'revenue' => $request->input("revenue"),
            'operations_costs' => $request->input("operations_costs"),
            'clsg_total' => $request->input("clsg_total"),
            'challenges' => $request->input("challenges"),
            'expected_activities' => $request->input("expected_activities"),
            'essential' => json_encode($request->input("essential")),
            'customer' => json_encode($request->input("customer")),
            'staff' => json_encode($request->input("staff")),
            'communication' => json_encode($request->input("communication")),
            'bcp_id' => auth()->user()->wsps()->first()->bcp->first()->id,
            'month' => $request->input("month"),
            'year' => $request->input("year"),
        ]);
        return response()->json($bcp);
    }

    public function saveVerification(MonthlyVerificationRequest $request)
    {
        $verification = MonthlyVerificationReport::where('month', $request->input("month"))
            ->where('year', $request->input("year"))
            ->where('wsp_id', auth()->user()->wsps->first()->id)
            ->first();

        if ($verification) {
            return response()->json([
                'message' => 'The given field was invalid',
                'errors' => ['month' => ['A Monthly Performance Verification Report for this WSP already exists for this period!']]
            ], 422);
        }
        $verification = MonthlyVerificationReport::create([
            'performance_score_details' => json_encode($request->input("performance_score_details")),
            'clsg_details' => json_encode($request->input("clsg_details")),
            'wsp_id' => auth()->user()->wsps->first()->id,
            'recommendations' => $request->input("recommendations"),
            'verification_team' => $request->input("verification_team"),
            'month' => $request->input("month"),
            'year' => $request->input("year"),
        ]);
        return response()->json($verification);
    }
    public function saveFormat(Request $request)
    {
        $format = MonthlyReportingFormat::create([
            'wsp_id'=>auth()->user()->wsps->first()->id,
            'bcp_status_implementation'=> $request->input("bcp_status_implementation"),
            'covid_status_implementation'=> $request->input("covid_status_implementation"),
            'revenues_collected'=> $request->input("revenues_collected"),
            'o_m_costs'=>$request->input("o_m_costs"),
            'amount_disbursed'=>$request->input("amount_disbursed"),
            'resolution_status'=>$request->input("resolution_status"),
            'challenges'=>$request->input("challenges"),
            'expected_activities_next_month'=>$request->input("expected_activities_next_month"),
            'scores_details'=> json_encode($request->input("scores")),
            'month' =>   $request->input("month"),
            'year' =>   $request->input("year"),
        ]);
        return response()->json($format);
    }

    public function getChecklist(Request $request)
    {

        $checklist = BcpMonthlyReport::where("month", $request->get("month"))->where("year", $request->get("year"))->where('bcp_id',auth()->user()->wsps()->first()->bcp->first()->id
        )->first();
        if ($checklist) $checklist = new BcpChecklistResource($checklist);
        else $checklist = [];
        return response()->json($checklist);
    }

    public function getVerification(Request $request)
    {
        $verification = MonthlyVerificationReport::where("month", $request->get("month"))->where("year", $request->get("year"))->where("wsp_id",auth()->user()->wsps->first()->id)->first();
        if ($verification) $verification = new VerificationResource($verification);
        else $verification = [];
        return response()->json($verification);
    }
    public function getFormat(Request $request)
    {
        $format = MonthlyReportingFormat::where("month",$request->get("month"))->where("year",$request->get("year"))->where('wsp_id',auth()->user()->wsps->first()->id)->first();
        if ($format) $format = new ReportingFormatResource($format);
        else $format = [];
        return response()->json($format);
    }
}
