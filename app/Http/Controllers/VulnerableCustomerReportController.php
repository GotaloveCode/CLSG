<?php

namespace App\Http\Controllers;

use App\Http\Resources\VulnerableCustomerResource;
use App\Models\BcpChecklist;
use App\Models\VulnerableCustomer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VulnerableCustomerReportController extends Controller
{

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
        $customer = VulnerableCustomer::create([
            'bcp_id' => auth()->user()->wsps()->first()->bcp->first()->id,
            'customer_details' => json_encode($request->input("customer_details")),
            'month' => $this->getMonth(),
            'year' => $this->getYear(),
        ]);
        return response()->json($customer);
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
        //
    }


}
