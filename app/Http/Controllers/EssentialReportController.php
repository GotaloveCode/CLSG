<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\EssentialReportResource;
use App\Http\Resources\VulnerableCustomerResource;
use App\Models\BcpChecklist;
use App\Models\EssentialOperationReport;
use App\Traits\EssentialOperationReportAuthTrait;
use App\Traits\SendMailNotification;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class EssentialReportController extends Controller
{
    use EssentialOperationReportAuthTrait;

    public function index()
    {
        if (!request()->ajax()) {
            return view('checklists.essential.index');
        }

        $wsp = auth()->user()->wsps()->first();

        if ($wsp) {
            if ($wsp->bcp) {
                $essential = EssentialOperationReport::where('bcp_id', $wsp->bcp->id)->get();
            } else {
                $essential = [];
            }
        } else {
            $essential = EssentialOperationReport::get();
        }

        $essential = EssentialReportResource::collection($essential);

        return Datatables::of($essential)
            ->addColumn('action', function ($essential) {
                return '<a href="' . route("essential-operation.show", $essential['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);
    }


    public function create()
    {
        $exiting_essential = EssentialOperationReport::where('bcp_id', auth()->user()->wsps()->first()->bcp->id)->latest()->first();

        $exiting_essential ? $essential_item = json_encode(new VulnerableCustomerResource($exiting_essential)) : $essential_item = json_encode([]);
        $items = json_encode(BcpChecklist::all());

        return view("checklists.essential.create", compact("items", "essential_item"));
    }


    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|in:' . now()->year,
            'month' => 'required|in:' . now()->month . ',' . (now()->month - 1),
            'details' => 'required'
        ]);
        $wsp = auth()->user()->wsps()->first();
        $bcp = $wsp->bcp;
        $report = EssentialOperationReport::create([
            'bcp_id' => $bcp->id,
            'details' => json_encode($request->input("details")),
            'month' => $request->month,
            'year' => $request->year,
            'status' => 'Pending'
        ]);

        SendMailNotification::created($wsp,
            route('essential-operation.show', $report->id),
            'Essential Operations report submitted',
            $wsp->name . ' submitted Essential Operation report for ' . \DateTime::createFromFormat("!m", $report->month)->format("F") .
            ' ' . $report->year
        );

        return response()->json($report);
    }


    public function show(EssentialOperationReport $essential_operation)
    {
        $essential = $essential_operation;
        $checklist = BcpChecklist::all();
        if (\request()->has('print')) {
            $pdf = \PDF::loadView('checklists.essential.print', compact('essential', 'checklist'));
            return $pdf->inline();
        }
        $progress = $essential->progress();

        return view("checklists.essential.show", compact("essential", "checklist", "progress"));
    }


    public function update(Request $request, EssentialOperationReport $essential_operation)
    {
        $essential_operation->update([
            'details' => json_encode($request->input("details")),
            'status' => 'Pending'
        ]);
    }

    public function review(EssentialOperationReport $report, Request $request)
    {
        $this->canAccessEssentialOperationReport($report);
        $report->status = $request->status;
        $report->save();
        $wsp = $report->bcp->wsp;

        $route = route('essential-operation.show', $report->id);
        SendMailNotification::postReview($request->status, $wsp->id, $route, $wsp->name . ' Essential Operations Report Review');

        return response()->json([
            'message' => 'Essential Operations Report status changed to ' . $request->status,
            'route' => $route
        ]);
    }

    public function comment(EssentialOperationReport $report, CommentRequest $request)
    {
        $this->canAccessEssentialOperationReport($report);

        $report->comments()->create([
            'description' => $request->description,
            'user_id' => auth()->id()
        ]);
        $wsp = $report->bcp->wsp;

        $route = route('essential-operation.show', $report->id);
        SendMailNotification::postComment($request->description, $report->status, $wsp->id, $route, $wsp->name . ' Essential Operations Reporting Comment');

        return response()->json(['message' => 'Comment posted successfully']);
    }

}
