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
use App\Models\EssentialOperationReport;
use App\Models\VulnerableCustomer;
use App\Models\Wsp;
use App\Models\Service;
use App\Models\WspReporting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\BcpChecklistResource;
use App\Http\Resources\VerificationResource;
use App\Http\Resources\ReportingFormatResource;
use App\Http\Resources\EssentialReportResource;
use App\Http\Resources\VulnerableCustomerResource;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;


class ReportsController extends Controller
{

    public function index()
    {

        return view("checklists.index");
    }

    public function wspIndex()
    {
        $services = Cache::rememberForever('services', function () {
            return Service::select('id', 'name')->get();
        });
        return view("checklists.wsps.index",compact("services"));
    }

    public function monthlyVerification()
    {
        $year = Carbon::now()->format("Y");
        $month = Carbon::now()->format("m");
        $exiting_verification = MonthlyVerificationReport::where("month", $month)->where("year", $year)->where('wsp_id', auth()->user()->wsps->first()->id)->first();
        $exiting_verification ? $verification_item = json_encode(new VerificationResource($exiting_verification)) : $verification_item = json_encode([]);
        $verification_items = json_encode(MonthlyVerification::all());
        return view("verification.index")->with(compact('verification_items', 'verification_item'));
    }

    public function monthlyChecklist()
    {
        $year = Carbon::now()->format("Y");
        $month = Carbon::now()->format("m");
        $exiting_checklist = BcpMonthlyReport::where("month", $month)->where("year", $year)->where('bcp_id', auth()->user()->wsps->first()->bcp->first()->id)->first();
        $exiting_checklist ? $checklist_item = json_encode(new BcpChecklistResource($exiting_checklist)) : $checklist_item = json_encode([]);
        $checklists = json_encode(BcpChecklist::all());
        return view("checklists.index", compact("checklists", "checklist_item"));
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

    public function essentialIndex()
    {
        if (!request()->ajax()) {
            return view('checklists.essential.list');
        }
        $essential = EssentialReportResource::collection(EssentialOperationReport::get());

        return Datatables::of($essential)
            ->addColumn('action', function ($essential) {
                return '<a href="' . route("essential-operation.show", $essential['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);

    }

    public function customerIndex()
    {

        if (!request()->ajax()) {
            return view('checklists.customer.list');
        }
        $customer = VulnerableCustomerResource::collection(VulnerableCustomer::get());

        return Datatables::of($customer)
            ->addColumn('action', function ($customer) {
                return '<a href="' . route("vulnerable-customer.show", $customer['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);

    }

    public function monthlyReportFormat()
    {
        $year = Carbon::now()->format("Y");
        $month = Carbon::now()->format("m");

        $exiting_format = MonthlyReportingFormat::where("month", $month)->where("year", $year)->where('wsp_id', auth()->user()->wsps->first()->id)->first();
        $exiting_format ? $format_item = json_encode(new ReportingFormatResource($exiting_format)) : $format_item = json_encode([]);
        $items = json_encode(ReportingFormart::all());

        return view("formats.index", compact("items", "format_item"));

    }

    public function createEssential()
    {

        $year = Carbon::now()->format("Y");
        $month = Carbon::now()->format("m");

        $exiting_essential = EssentialOperationReport::where("month", $month)->where("year", $year)->where('bcp_id', auth()->user()->wsps()->first()->bcp->first()->id)->first();

        $exiting_essential ? $essential_item = json_encode(new EssentialReportResource($exiting_essential)) : $essential_item = json_encode([]);
        $items = json_encode(BcpChecklist::all());

        return view("checklists.essential.index", compact("items", "essential_item"));
    }
    public function createCustomer()
    {

        $year = Carbon::now()->format("Y");
        $month = Carbon::now()->format("m");

        $exiting_customer = VulnerableCustomer::where("month", $month)->where("year", $year)->where('bcp_id', auth()->user()->wsps()->first()->bcp->first()->id)->first();
        $exiting_customer ? $customer = json_encode(new VulnerableCustomerResource($exiting_customer)) : $customer = json_encode([]);
        $items = json_encode(BcpChecklist::all());

        return view("checklists.customer.index", compact("items", "customer"));
    }

    public function showVerification($id)
    {
        $verify = json_encode(new VerificationResource(MonthlyVerificationReport::find($id)));
        $checklist_items = json_encode(MonthlyVerification::all());
        return view("verification.show", compact("verify", "checklist_items"));
    }

    public function showChecklist($id)
    {
        $checklist = json_encode(new BcpChecklistResource(BcpMonthlyReport::find($id)));
        $checklist_items = json_encode(BcpChecklist::all());
        return view("checklists.show", compact("checklist", "checklist_items"));
    }

    public function showFormat($id)
    {
        $format = json_encode(new ReportingFormatResource(MonthlyReportingFormat::find($id)));
        $items = json_encode(ReportingFormart::all());
        return view("formats.show", compact("format", "items"));
    }

    public function showEssentialOperation($id)
    {
        $essential = json_encode(new EssentialReportResource(EssentialOperationReport::find($id)));
        $items = json_encode(BcpChecklist::all());
        return view("checklists.essential.show", compact("essential", "items"));
    }
    public function showCustomer($id)
    {
        $checklist = json_encode(new VulnerableCustomerResource(VulnerableCustomer::find($id)));
        $customers = json_encode(BcpChecklist::where("type","Vulnerable Customers")->get());
        $staff = json_encode(BcpChecklist::where("type","Staff Health Protection")->get());
        return view("checklists.customer.show", compact("customers", "checklist","staff"));
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
            'month' => Carbon::now()->format("m"),
            'year' => Carbon::now()->format("Y"),
        ]);
        return response()->json($bcp);
    }

    public function saveVerification(MonthlyVerificationRequest $request)
    {
        $verification = MonthlyVerificationReport::create([
            'performance_score_details' => json_encode($request->input("performance_score_details")),
            'clsg_details' => json_encode($request->input("clsg_details")),
            'wsp_id' => auth()->user()->wsps->first()->id,
            'recommendations' => $request->input("recommendations"),
            'verification_team' => $request->input("verification_team"),
            'month' => Carbon::now()->format("m"),
            'year' => Carbon::now()->format("Y"),
        ]);
        return response()->json($verification);
    }

    public function saveFormat(Request $request)
    {
        $format = MonthlyReportingFormat::create([
            'wsp_id' => auth()->user()->wsps->first()->id,
            'bcp_status_implementation' => $request->input("bcp_status_implementation"),
            'covid_status_implementation' => $request->input("covid_status_implementation"),
            'revenues_collected' => $request->input("revenues_collected"),
            'o_m_costs' => $request->input("o_m_costs"),
            'amount_disbursed' => $request->input("amount_disbursed"),
            'resolution_status' => $request->input("resolution_status"),
            'challenges' => $request->input("challenges"),
            'expected_activities_next_month' => $request->input("expected_activities_next_month"),
            'scores_details' => json_encode($request->input("scores")),
            'month' => Carbon::now()->format("m"),
            'year' => Carbon::now()->format("Y"),
        ]);
        return response()->json($format);
    }
    public function saveWsp(Request $request)
    {
        $request['month'] = Carbon::now()->format("m");
        $request['year'] = Carbon::now()->format("Y");
        $request['bcp_id'] = auth()->user()->wsps()->first()->bcp->first()->id;
        $request['status_of_covid_implementation'] = json_encode($request->input("status_of_covid_implementation")) ;
        $request['expected_activities'] = json_encode($request->input("expected_activities")) ;
        $reporting = WspReporting::create($request->all());
        return response()->json($reporting);
    }

    public function saveEssential(Request $request)
    {
        $format = EssentialOperationReport::create([
            'bcp_id' => auth()->user()->wsps()->first()->bcp->first()->id,
            'details' => json_encode($request->input("details")),
            'month' => Carbon::now()->format("m"),
            'year' => Carbon::now()->format("Y"),
        ]);
        return response()->json($format);
    }
    public function saveCustomer(Request $request)
    {
        $customer = VulnerableCustomer::create([
            'bcp_id' => auth()->user()->wsps()->first()->bcp->first()->id,
            'customer_details' => json_encode($request->input("customer_details")),
            'staff_details' => json_encode($request->input("staff_details")),
            'month' => Carbon::now()->format("m"),
            'year' => Carbon::now()->format("Y"),
        ]);
        return response()->json($customer);
    }

}
