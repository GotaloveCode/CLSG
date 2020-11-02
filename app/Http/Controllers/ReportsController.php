<?php

namespace App\Http\Controllers;

use App\Models\EssentialOperationReport;
use App\Models\VulnerableCustomer;
use App\Models\Wsp;
use App\Models\Service;
use App\Models\WspReporting;
use App\Models\CslgCalculation;
use App\Models\StaffHealth;
use App\Models\PerformanceScore;
use App\Models\BcpChecklist;
use App\Models\Erp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\EssentialReportResource;
use App\Http\Resources\VulnerableCustomerResource;
use App\Http\Resources\WspReportingResource;
use App\Http\Resources\CslgResource;
use App\Http\Resources\StaffHealthResource;
use App\Http\Resources\PerformaceScoreResource;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;


class ReportsController extends Controller
{

    public function wspIndex()
    {
        if (!request()->ajax()) {
            return view('checklists.wsps.list');
        }
        $reporting = WspReportingResource::collection(WspReporting::get());

        return Datatables::of($reporting)
            ->addColumn('action', function ($reporting) {

                return '<a href="' . route("wsp-reporting.show", $reporting['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);

    }
    public function cardIndex()
    {
        if (!request()->ajax()) {
            return view('checklists.performance.list');
        }
        $score = PerformaceScoreResource::collection(PerformanceScore::get());

        return Datatables::of($score)
            ->addColumn('action', function ($score) {

                return '<a href="' . route("performance-score-card.show", $score['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);

    }
    public function cslgIndex()
    {
        if (!request()->ajax()) {
            return view('checklists.cslg.list');
        }
        $reporting = CslgResource::collection(CslgCalculation::get());

        return Datatables::of($reporting)
            ->addColumn('action', function ($reporting) {
                return '<a href="' . route("cslg-calculation.show", $reporting['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);
    }
    public function staffIndex()
    {
        if (!request()->ajax()) {
            return view('checklists.staff.list');
        }
        $staff = StaffHealthResource::collection(StaffHealth::get());

        return Datatables::of($staff)
            ->addColumn('action', function ($staff) {
                return '<a href="' . route("staff-health.show", $staff['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
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
    public function createWsp()
    {

        $year = Carbon::now()->format("Y");
        $month = Carbon::now()->format("m");

        $exiting_wsp = WspReporting::where("month", $month)->where("year", $year)->where('bcp_id', auth()->user()->wsps()->first()->bcp->first()->id)->first();
        $exiting_wsp ? $wsp_report = json_encode(new WspReportingResource($exiting_wsp)) : $wsp_report = json_encode([]);
           $services = Cache::rememberForever('services', function () {
            return Service::select('id', 'name')->get();
        });

        return view("checklists.wsps.index", compact( "wsp_report","services"));
    }
    public function createCslg()
    {

        $year = Carbon::now()->format("Y");
        $month = Carbon::now()->format("m");

        $exiting_cslg = CslgCalculation::where("month", $month)->where("year", $year)->where('bcp_id', auth()->user()->wsps()->first()->bcp->first()->id)->first();
        $exiting_cslg ? $cslg = json_encode(new CslgResource($exiting_cslg)) : $cslg = json_encode([]);

        $operations = WspReporting::select("clsg_total","operations_costs","revenue")->where("month", $month)->where("year", $year)->where('bcp_id', auth()->user()->wsps()->first()->bcp->first()->id)->first(); ;
        if (!$operations) return redirect()->back()->with('success', 'Please ensure you have created WSP Reporting first');

        $erp =Erp::where('wsp_id',auth()->user()->wsps()->first()->bcp->first()->id)->first();
        if (!$erp) return redirect()->back()->with('success', 'Please ensure you have created ERP first');
        $grant = $erp->erp_items->sum('cost');

        return view("checklists.cslg.index", compact( "cslg","operations",'grant'));
    }
    public function createStaff()
    {
        $year = Carbon::now()->format("Y");
        $month = Carbon::now()->format("m");

        $exiting_staff = StaffHealth::where("month", $month)->where("year", $year)->where('bcp_id', auth()->user()->wsps()->first()->bcp->first()->id)->first();
        $exiting_staff ? $staff = json_encode(new StaffHealthResource($exiting_staff)) : $staff = json_encode([]);
        $items = json_encode(BcpChecklist::all());
        return view("checklists.staff.index", compact( "staff","items"));
    }
    public function createCard()
    {
        $year = Carbon::now()->format("Y");
        $month = Carbon::now()->format("m");

        $exiting_score = PerformanceScore::where("month", $month)->where("year", $year)->where('bcp_id', auth()->user()->wsps()->first()->bcp->first()->id)->first();
        $exiting_score ? $score = json_encode(new PerformaceScoreResource($exiting_score)) : $score = json_encode([]);

       $wsp = WspReporting::where("month", $month)->where("year", $year)->where('bcp_id', auth()->user()->wsps()->first()->bcp->first()->id)->first();
       if (!$wsp) return redirect()->back()->with("success","Please ensure you have have filled in the general checklist form first");
       return view("checklists.performance.index", compact( "score"));
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
    public function showStaff($id)
    {
        $checklist = json_encode(new StaffHealthResource(StaffHealth::find($id)));
        $staff = json_encode(BcpChecklist::where("type","Staff Health Protection")->get());
        return view("checklists.staff.show", compact( "checklist","staff"));
    }
     public function showWsp($id)
        {
            $services = Cache::rememberForever('services', function () {
                return Service::select('id', 'name')->get();
            });

            $wsp_report = json_encode(new WspReportingResource(WspReporting::find($id)));
            return view("checklists.wsps.show", compact("wsp_report", "services"));
        }
        public function showCslg($id)
        {
            $item = CslgCalculation::find($id);
            $operations = WspReporting::select("clsg_total","operations_costs","revenue")->where("month", $item->month)->where("year", $item->year)->where('bcp_id', $item->bcp_id)->first(); ;
            if (!$operations) return redirect()->back();
            $cslg = json_encode(new CslgResource($item));

            return view("checklists.cslg.show", compact("cslg","operations"));
        }
        public function showCard($id)
        {
            $score = json_encode(new PerformaceScoreResource(PerformanceScore::find($id)));
            return view("checklists.performance.show", compact("score"));
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
            'month' => Carbon::now()->format("m"),
            'year' => Carbon::now()->format("Y"),
        ]);
        return response()->json($customer);
    }
    public function saveStaff(Request $request)
    {
        $staff = StaffHealth::create([
            'bcp_id' => auth()->user()->wsps()->first()->bcp->first()->id,
            'staff_details' => json_encode($request->input("staff_details")),
            'month' => Carbon::now()->format("m"),
            'year' => Carbon::now()->format("Y"),
        ]);
        return response()->json($staff);
    }
    public function saveCslg(Request $request)
    {
        $request['month'] = Carbon::now()->format("m");
        $request['year'] = Carbon::now()->format("Y");
        $request['bcp_id'] = auth()->user()->wsps()->first()->bcp->first()->id;
        $cslg = CslgCalculation::create($request->all());
        return response()->json($cslg);
    }
    public function saveCard(Request $request)
    {
        $request['month'] = Carbon::now()->format("m");
        $request['year'] = Carbon::now()->format("Y");
        $request['bcp_id'] = auth()->user()->wsps()->first()->bcp->first()->id;
        $score = PerformanceScore::create($request->all());
        return response()->json($score);
    }

}
