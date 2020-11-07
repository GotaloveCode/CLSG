<?php

namespace App\Http\Controllers;

use App\Http\Requests\BcpFormRequest;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\MgmRequest;
use App\Http\Resources\BcpResource;
use App\Models\Bcp;
use App\Models\Essentialfunction;
use App\Traits\BcpAuthTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\SendMailNotification;
use PDF;


class BcpController extends Controller
{
    use SendMailNotification, BcpAuthTrait;

    public function index()
    {
        if (!request()->ajax()) {
            return view('bcps.index');
        }
        $bcp = Bcp::query()->with('wsp:id,name')->select('bcps.*');

        return Datatables::of($bcp)
            ->addColumn('action', function ($bcp) {
                return '<a href="' . route("bcps.show", $bcp->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);
    }

    public function create()
    {
        $wsp = auth()->user()->wsps()->first();
        if (!isset($wsp->eoi) || $wsp->eoi->status !== "WSTF Approved") {
            return redirect(route("eois.create"))->withErrors('Expression of Interest first must be submitted to and approved by WSTF');
        }

        $operation_costs = $wsp->eoi->operationcosts()->get();
        $staff = $wsp->staff()->selectRaw("CONCAT(firstname,' ',lastname) as name,id,type")->get();
        $essential_functions = Essentialfunction::select('id', 'name')->get();
        $bcp_load = $wsp->bcp;

        if ($bcp_load) $bcp_load = json_encode(new BcpResource($bcp_load));
        else $bcp_load;

        return view('bcps.create')->with(compact('staff', 'operation_costs', 'essential_functions', 'bcp_load'));
    }

    public function store(BcpFormRequest $request)
    {
        $bcp = Bcp::where('wsp_id', $request->wsp_id)->first();
        if ($bcp) {
            return response()->json([
                'message' => 'The given field was invalid',
                'errors' => ['wsp_id' => ['A BCP already exists!']]
            ], 422);
        }

        $bcp = Bcp::create($request->validated());

        $this->createBcpRelations($bcp, $request);

        SendMailNotification::postReview($bcp->status, $bcp->wsp_id, route('bcps.show', $bcp->id), $bcp->wsp->name . ' BCP Created');

        if ($request->ajax()) {
            return response()->json(['message' => 'Business Continuity Plan submitted successfully', 'bcp' => $bcp]);
        }
        return back()->with('success', 'Business Continuity Plan submitted successfully');
    }

    public function update(BcpFormRequest $request, Bcp $bcp)
    {
        if ($bcp->status == "WSTF Approved") {
            return response()->json([
                'message' => 'The BCP has already been approved by WSFT no further changes can be made',
                'errors' => ['wsp_id' => ['The BCP has already been approved by WSFT no further changes can be made!']]
            ], 422);
        }
        $bcp->update([
            'executive_summary' => $request->input('executive_summary'),
            'introduction' => $request->input('introduction'),
            'planning_assumptions' => $request->input('planning_assumptions'),
            'training' => $request->input('training'),
            'staff_health_protection' => $request->input('staff_health_protection'),
            'supply_chain' => $request->input('supply_chain'),
            'emergency_response_plan' => $request->input('emergency_response_plan'),
            'communication_plan' => $request->input('communication_plan'),
            'government_subsidy' => $request->input('government_subsidy'),
            'wsp_id' => $request->input('wsp_id'),
            'status' => 'Pending'
        ]);

        $bcp->essentialOperations()->delete();
        $bcp->bcpteams()->delete();
        $bcp->revenue_projections()->delete();

        $this->createBcpRelations($bcp, $request);

        SendMailNotification::postReview($bcp->status, $bcp->wsp_id, route('bcps.show', $bcp->id), $bcp->wsp->name . ' BCP Updated');

        if ($request->ajax()) {
            return response()->json(['message' => 'Business Continuity Plan updated successfully']);
        }
        return back()->with('success', 'Business Continuity Plan updated successfully');
    }

    public function mgm(MgmRequest $request, Bcp $bcp)
    {
        foreach ($request->input('mgms') as $mgm) {
            $bcp->mgms()->updateOrCreate([
                'month' => $mgm['month'],
                'year' => $mgm['year']
            ], [
                'amount' => $mgm['amount']
            ]);
        }

        //#todo: add notification

        if ($request->ajax()) {
            return response()->json(['message' => 'Monthly Grant Multiplier updated successfully']);
        }
        return back()->with('success', 'Monthly Grant Multiplier updated successfully');
    }

    private function createBcpRelations(Bcp $bcp, Request $request)
    {
        foreach ($request->input('essential_operations') as $operation) {
            $bcp->essentialOperations()->create([
                'priority_level' => $operation['priority_level'],
                'primary_staff' => $operation['primary_staff'],
                'backup_staff' => $operation['backup_staff'],
                'essentialfunction_id' => $operation['essentialfunction_id'],
            ]);
        }

        foreach ($request->input('bcp_teams') as $member) {
            $bcp->bcpteams()->create([
                'name' => $member['name'],
                'unit' => $member['unit'],
                'role' => $member['role']
            ]);
        }

        foreach ($request->input('projected_revenues') as $revenue) {
            $bcp->revenue_projections()->create([
                'month' => $revenue['month'],
                'year' => now()->year,
                'amount' => $revenue['amount']
            ]);
        }
    }

    public function show(Bcp $bcp)
    {
        $eoi = $bcp->wsp->first()->eoi;
        $bcp = $bcp->load(['wsp', 'revenue_projections', 'essentialOperations', 'essentialOperations.essentialfunction', 'essentialOperations.primaryStaff', 'comments', 'comments.user', 'bcpteams']);

        if (\request()->has('print')) {
            $pdf = PDF::loadView('bcps.print', $bcp);
            return $pdf->download();
        }
        $progress = $bcp->progress();
        return view('bcps.show')->with(compact('bcp', 'progress', 'eoi'));
    }

    public function review(Bcp $bcp, Request $request)
    {
        $this->canAccessBcp($bcp);
        if ($bcp->status == "Pending" && $request->status == "WASREB Approved") {
            if ($bcp->mgms()->count() < 3) {
                return response()->json([
                    'message' => 'Please set Monthly Grant Multiplier first',
                    'errors' => ['status' => ['Please set Monthly Grant Multiplier first before approving!']]
                ], 422);
            }
        }
        $bcp->status = $request->status;
        $bcp->save();

        $route = route('bcps.show', $bcp->id);
        SendMailNotification::postReview($request->status, $bcp->wsp_id, $route, $bcp->wsp->name . ' BCP Review');

        return response()->json([
            'message' => 'Bcp status changed to ' . $request->status,
            'route' => $route
        ]);
    }

    public function comment(Bcp $bcp, CommentRequest $request)
    {
        $this->canAccessBcp($bcp);

        $bcp->comments()->create([
            'description' => $request->description,
            'user_id' => auth()->id()
        ]);

        $route = route('bcps.show', $bcp->id);
        SendMailNotification::postComment($request->description, $bcp->status, $bcp->wsp_id, $route, $bcp->wsp->name . ' BCP Comment');

        return response()->json(['message' => 'Comment posted successfully']);
    }

}
