<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\VulnerableCustomerResource;
use App\Models\BcpChecklist;
use App\Models\VulnerableCustomer;
use App\Traits\SendMailNotification;
use App\Traits\VulnerableCustomerReportAuthTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VulnerableCustomerReportController extends Controller
{
    use VulnerableCustomerReportAuthTrait;

    public function index()
    {
        if (!request()->ajax()) {
            return view('checklists.customer.index');
        }

        $wsp = auth()->user()->wsps()->first();

        if ($wsp) {
            if ($wsp->bcp) {
                $customer = VulnerableCustomer::where('bcp_id', $wsp->bcp->id)->get();
            } else {
                $customer = [];
            }
        } else {
            $customer = VulnerableCustomer::get();
        }

        $customer = VulnerableCustomerResource::collection($customer);

        return Datatables::of($customer)
            ->addColumn('action', function ($customer) {
                return '<a href="' . route("vulnerable-customer.show", $customer['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);
    }

    public function create()
    {
        $exiting_customer = VulnerableCustomer::where('bcp_id', auth()->user()->wsps()->first()->bcp->id)->latest()->first();
        $exiting_customer ? $customer = json_encode(new VulnerableCustomerResource($exiting_customer)) : $customer = json_encode([]);
        $items = json_encode(BcpChecklist::all());

        return view("checklists.customer.create", compact("items", "customer"));
    }


    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|in:' . now()->year,
            'month' => 'required|in:' . now()->month . ',' . (now()->month - 1),
            'customer_details' => 'required'
        ]);
        $wsp = auth()->user()->wsps()->first();
        $bcp = $wsp->bcp;
        $report = VulnerableCustomer::create([
            'bcp_id' => $bcp->id,
            'customer_details' => json_encode($request->input("customer_details")),
            'month' => $request->month,
            'year' => $request->year,
            'status' => 'Pending'
        ]);
        SendMailNotification::created($wsp,
            route('vulnerable-customer.show', $report->id),
            'Vulnerable customer report submitted',
            $wsp->name . ' submitted Vulnerable customer report for ' . \DateTime::createFromFormat("!m", $report->month)->format("F") .
            ' ' . $report->year
        );
        return response()->json($report);
    }

    public function show(VulnerableCustomer $vulnerable_customer)
    {
        $checklist = json_encode(new VulnerableCustomerResource($vulnerable_customer));
        $customers = json_encode(BcpChecklist::where("type", "Vulnerable Customers")->get());
        $staff = json_encode(BcpChecklist::where("type", "Staff Health Protection")->get());
        if (\request()->has('print')) {
            $pdf = \PDF::loadView('checklists.customer.print', compact('customer'));
            return $pdf->inline();
        }
        return view("checklists.customer.show", compact("customers", "checklist", "staff"));
    }


    public function update(Request $request, VulnerableCustomer $vulnerable_customer)
    {
        $vulnerable_customer->update([
            'customer_details' => json_encode($request->input("customer_details")),
            'status' => 'Pending'
        ]);
        return response()->json($vulnerable_customer);
    }

    public function review(VulnerableCustomer $report, Request $request)
    {
        $this->canAccessVulnerableCustomerReport($report);
        $report->status = $request->status;
        $report->save();
        $wsp = $report->bcp->wsp;

        $route = route('vulnerable-customer.show', $report->id);
        SendMailNotification::postReview($request->status, $wsp->id, $route, $wsp->name . ' Vulnerable Customer Report Review');

        return response()->json([
            'message' => 'Vulnerable Customer Report status changed to ' . $request->status,
            'route' => $route
        ]);
    }

    public function comment(VulnerableCustomer $report, CommentRequest $request)
    {
        $this->canAccessVulnerableCustomerReport($report);

        $report->comments()->create([
            'description' => $request->description,
            'user_id' => auth()->id()
        ]);
        $wsp = $report->bcp->wsp;

        $route = route('vulnerable-customer.show', $report->id);
        SendMailNotification::postComment($request->description, $report->status, $wsp->id, $route, $wsp->name . ' Vulnerable Customer Reporting Comment');

        return response()->json(['message' => 'Comment posted successfully']);
    }
}
