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
        $format = EssentialOperationReport::create([
            'bcp_id' => auth()->user()->wsps()->first()->bcp->first()->id,
            'details' => json_encode($request->input("details")),
            'month' => $request->month,
            'year' => $request->year,
        ]);
        return response()->json($format);
    }


    public function show($id)
    {
        $essential = json_encode(new EssentialReportResource(EssentialOperationReport::find($id)));
        $items = json_encode(BcpChecklist::all());
        return view("checklists.essential.show", compact("essential", "items"));
    }


    public function update(Request $request, $id)
    {
        //
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
