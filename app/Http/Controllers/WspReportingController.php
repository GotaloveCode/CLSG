<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\WspReportingResource;
use App\Models\Operationcost;
use App\Models\Service;
use App\Models\WspReporting;
use App\Traits\SendMailNotification;
use App\Traits\WspReportAuthTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class WspReportingController extends Controller
{
    use WspReportAuthTrait;

    public function index()
    {
        if (!request()->ajax()) {
            return view('checklists.wsps.index');
        }

        $wsp = auth()->user()->wsps()->first();

        if ($wsp) {
            if ($wsp->bcp) {
                $reporting = WspReporting::where('bcp_id', $wsp->bcp->id)->get();
            } else {
                $reporting = [];
            }
        } else {
            $reporting = WspReporting::get();
        }

        $reporting = WspReportingResource::collection($reporting);

        return Datatables::of($reporting)
            ->addColumn('action', function ($reporting) {
                return '<a href="' . route("wsp-reporting.show", $reporting['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);

    }

    public function create()
    {
        $exiting_wsp = WspReporting::where('bcp_id', auth()->user()->wsps()->first()->bcp->id)->latest()->first();
        $exiting_wsp ? $wsp_report = json_encode(new WspReportingResource($exiting_wsp)) : $wsp_report = null;
        $services = Cache::rememberForever('services', function () {
            return Service::select('id', 'name')->get();
        });
        $operationCosts = Cache::rememberForever('operationCosts', function () {
            return Operationcost::select('id', 'name')->get();
        });
        $attachments = $exiting_wsp ? $exiting_wsp->attachments : null;
        return view("checklists.wsps.create")->with(compact("wsp_report", "attachments", "services", "operationCosts"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|in:' . now()->year,
            'month' => 'required|in:' . now()->month . ',' . (now()->month - 1),
            'status_of_covid_implementation.*.service' => 'required',
            'operations_costs.*.amount' => 'required|numeric',
        ]);
        $status_of_impl = [];
        $operations_costs = [];
        foreach ($request->get('status_of_covid_implementation') as $value) {
            $status_of_impl[] = [
                'service' => $value['service'],
                'description' => $value['description'],
                'cost' => $value['cost']
            ];
        }

        foreach ($request->get('operations_costs') as $value) {
            $operations_costs[] = [
                'id' => $value['id'],
                'amount' => $value['amount']
            ];
        }
        $wsp = auth()->user()->wsps()->first();
        $bcp = $wsp->bcp;
        $request['month'] = $request->month;
        $request['year'] = $request->year;
        $request['bcp_id'] = $bcp->id;
        $request['status_of_covid_implementation'] = json_encode($status_of_impl);
        $request['operations_costs'] = json_encode($operations_costs);
        $request['expected_activities'] = json_encode($request->input("expected_activities"));
        $request['status'] = "Pending";

        $reporting = WspReporting::create($request->all());

        SendMailNotification::created($wsp,
            route('essential-operation.show', $reporting->id),
            'WSP Monthly Report submitted',
            $wsp->name . ' submitted WSP Monthly report for ' . \DateTime::createFromFormat("!m", $reporting->month)->format("F") .
            ' ' . $reporting->year
        );

        return response()->json($reporting);
    }

    public function update(Request $request, WspReporting $wsp_reporting)
    {
        $status_of_impl = [];
        $operations_costs = [];
        foreach ($request->get('status_of_covid_implementation') as $value) {
            $status_of_impl[] = [
                'service' => $value['service'],
                'description' => $value['description'],
                'cost' => $value['cost']
            ];
        }

        foreach ($request->get('operations_costs') as $value) {
            $operations_costs[] = [
                'id' => $value['id'],
                'amount' => $value['amount']
            ];
        }
        $wsp_reporting->update([
            'month' => $request->month,
            'year' => $request->year,
            'status_of_covid_implementation' => json_encode($status_of_impl),
            'operations_costs' => json_encode($operations_costs),
            'expected_activities' => json_encode($request->input("expected_activities")),
            'status' => "Pending",
        ]);
        return response()->json($wsp_reporting);
    }

    public function show($wsp_reporting)
    {
        $report = WspReporting::find($wsp_reporting);

        $services = Cache::rememberForever('services', function () {
            return Service::select('id', 'name')->get();
        });
        $operationCosts = Cache::rememberForever('operationCosts', function () {
            return Operationcost::select('id', 'name')->get();
        });

        $wsp_report = $report->load('comments', 'attachments', 'bcp', 'bcp.wsp');

        if (\request()->has('print')) {
            $pdf = PDF::loadView('checklists.wsps.print', compact('wsp_report', 'services', 'operationCosts'));
            return $pdf->inline();
        }

        $attachments = $report->attachments;
        $progress = $report->progress();

        return view("checklists.wsps.show", compact("wsp_report", "attachments", "services", 'operationCosts', 'progress'));
    }

    public function review(WspReporting $report, Request $request)
    {
        $this->canAccessWspReporting($report);
        $report->status = $request->status;
        $report->save();
        $wsp = $report->bcp->wsp;

        $route = route('wsp-reporting.show', $report->id);
        SendMailNotification::postReview($request->status, $wsp->id, $route, $wsp->name . ' WSP Monthly Report Review');

        return response()->json([
            'message' => 'WSP Monthly Report status changed to ' . $request->status,
            'route' => $route
        ]);
    }

    public function comment(WspReporting $report, CommentRequest $request)
    {
        $this->canAccessWspReporting($report);

        $report->comments()->create([
            'description' => $request->description,
            'user_id' => auth()->id()
        ]);
        $wsp = $report->bcp->wsp;

        $route = route('wsp-reporting.show', $report->id);
        SendMailNotification::postComment($request->description, $report->status, $wsp->id, $route, $wsp->name . ' Monthly WSP Reporting Comment');

        return response()->json(['message' => 'Comment posted successfully']);
    }

}
