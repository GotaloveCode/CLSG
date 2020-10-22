<?php

namespace App\Http\Controllers;

use App\Http\Requests\EoiRequest;
use App\Mail\EioReview;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\EoiReviewRequest;
use App\Models\Attachment;
use App\Models\Connection;
use App\Models\Eoi;
use App\Models\Estimatedcost;
use App\Models\Operationcost;
use App\Models\Service;
use App\Traits\EoiAuthTrait;
use App\Traits\FilesTrait;
use App\Traits\SendMailNotification;
use App\Http\Resources\EoiCustomResource;
use App\Http\Resources\EoiListResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

use PDF;

class EoiController extends Controller
{
    use FilesTrait, EoiAuthTrait, SendMailNotification;

    public function index()
    {
        if (!request()->ajax()) {
            return view('eoi.index');
        }

        $eois = Eoi::query()->select('eois.id', 'fixed_grant', 'variable_grant', 'emergency_intervention_total', 'operation_costs_total', 'wsp_id', 'wsps.name', 'eois.created_at', 'status')
            ->with('wsp:id,name');

        if (auth()->user()->hasRole('wsp')) {
            $eois = $eois->where('wsp_id', auth()->user()->wsps()->first()->id);
        }

        return Datatables::of($eois)
            ->addColumn('action', function ($eoi) {
                return '<a href="' . route("eois.show", $eoi->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Review</a>';
            })
            ->make(true);
    }

    public function create()
    {
        if (!auth()->user()->can('create-eoi')) {
            abort('403', "You don't have permissions to create EOI");
        }
        $services = Cache::rememberForever('services', function () {
            return Service::select('id', 'name')->get();
        });
        $connections = Cache::rememberForever('connections', function () {
            return Connection::select('id', 'name')->get();
        });
        $estimatedCosts = Cache::rememberForever('estimatedCosts', function () {
            return Estimatedcost::select('id', 'name')->get();
        });
        $operationCosts = Cache::rememberForever('operationCosts', function () {
            return Operationcost::select('id', 'name')->get();
        });

        return view('eoi.create')->with(compact('services', 'connections', 'estimatedCosts', 'operationCosts'));
    }

    public function store(EoiRequest $request)
    {
        $eoi = Eoi::create([
            'program_manager' => $request->input('program_manager'),
            'fixed_grant' => $request->input('fixed_grant'),
            'variable_grant' => $request->input('variable_grant'),
            'emergency_intervention_total' => $request->input('emergency_intervention_total'),
            'operation_costs_total' => $request->input('operation_costs_total'),
            'water_service_areas' => $request->input('water_service_areas'),
            'total_people_water_served' => $request->input('total_people_water_served'),
            'proportion_served' => $request->input('proportion_served'),
            'date' => now(),
            'months' => 3,
            'wsp_id' => $request->input('wsp'),
            'status' => 'Pending'
        ]);

        foreach ($request->input('services') as $service) {
            $eoi->services()->attach($service['service_id'], [
                'areas' => $service['areas'],
                'total' => $service['total'],
            ]);
        }

        foreach ($request->input('connections') as $connection) {
            $eoi->connections()->attach($connection['connection_id'], [
                'areas' => $connection['areas'],
                'total' => $connection['total'],
            ]);
        }

        foreach ($request->input('estimated_costs') as $estimated_cost) {
            $eoi->estimatedcosts()->attach($estimated_cost['estimatedcost_id'], [
                'unit' => $estimated_cost['unit'],
                'total' => $estimated_cost['total'],
            ]);
        }

        foreach ($request->input('operation_costs') as $operation_cost) {
            $eoi->operationcosts()->attach($operation_cost['operationcost_id'], [
                'unit_rate' => $operation_cost['unit_rate'],
                'quantity' => $operation_cost['quantity'],
                'total' => $operation_cost['total'],
            ]);
        }

        if ($request->ajax()) {
            return response()->json($eoi);
        }
        return back()->with(['eoi' => $eoi]);
    }

    public function update(EoiRequest $request, Eoi $eoi)
    {
        $eoi->update([
            'program_manager' => $request->input('program_manager'),
            'fixed_grant' => $request->input('fixed_grant'),
            'variable_grant' => $request->input('variable_grant'),
            'emergency_intervention_total' => $request->input('emergency_intervention_total'),
            'operation_costs_total' => $request->input('operation_costs_total'),
            'water_service_areas' => $request->input('water_service_areas'),
            'total_people_water_served' => $request->input('total_people_water_served'),
            'proportion_served' => $request->input('proportion_served'),
            'date' => now(),
            'months' => 3,
            'wsp_id' => $request->input('wsp')
        ]);

        $eoi->services()->detach();
        $eoi->connections()->detach();
        $eoi->estimatedcosts()->detach();
        $eoi->operationcosts()->detach();

        foreach ($request->input('services') as $service) {
            $eoi->services()->attach($service['service_id'], [
                'areas' => $service['areas'],
                'total' => $service['total'],
            ]);
        }

        foreach ($request->input('connections') as $connection) {
            $eoi->connections()->attach($connection['connection_id'], [
                'areas' => $connection['areas'],
                'total' => $connection['total'],
            ]);
        }

        foreach ($request->input('estimated_costs') as $estimated_cost) {
            $eoi->estimatedcosts()->attach($estimated_cost['estimatedcost_id'], [
                'unit' => $estimated_cost['unit'],
                'total' => $estimated_cost['total'],
            ]);
        }

        foreach ($request->input('operation_costs') as $operation_cost) {
            $eoi->operationcosts()->attach($operation_cost['operationcost_id'], [
                'unit_rate' => $operation_cost['unit_rate'],
                'quantity' => $operation_cost['quantity'],
                'total' => $operation_cost['total'],
            ]);
        }

        if ($request->ajax()) {
            return response()->json($eoi);
        }
        return redirect()->back()->with(['eoi' => $eoi]);
    }

    public function show(Eoi $eoi)
    {
        $progress = $eoi->progress();
        $eoi = $eoi->load(['wsp', 'services', 'connections', 'estimatedcosts', 'operationcosts']);
        return view('eoi.show')->with(compact('eoi', 'progress'));
    }

    public function review(Eoi $eoi, EoiReviewRequest $request)
    {
        if (!auth()->user()->can('review-eoi')) {
            $this->canAccessEoi($eoi);
        }
        $eoi->status = $request->status;
        $eoi->save();

        $route = route('eoi.show', $eoi->id);
        SendMailNotification::postReview($request->status, $eoi->wsp_id, $route, $eoi->wsp->name . ' Eoi Review');

        if ($request->status == 'WSTF Approved') {
            $route = route('eois.commitment_letter', $eoi->id);
        }

        return response()->json([
            'message' => 'Eoi status changed to ' . $request->status,
            'route' => $route
        ]);
    }

    public function comment(Eoi $eoi, CommentRequest $request)
    {
        $this->canAccessEoi($eoi);

        $eoi->comments()->create([
            'description' => $request->description,
            'user_id' => auth()->id()
        ]);

        $route = route('bcps.show', $eoi->id);

        SendMailNotification::postComment($request->description, $eoi->status, $eoi->wsp_id, $route, $eoi->wsp->name . 'Eoi Comment');

        return response()->json(['message' => 'Comment posted successfully']);
    }


    public function commitment_letter(Eoi $eoi)
    {
        $this->validate_eoi_approved($eoi);
        if (request()->input('download')) {
            $pdf = PDF::loadView('preview.eoi', compact('eoi'));
            return $pdf->download('commitment-letter.pdf');
        }
        $eoi = $eoi->load(['wsp', 'wsp.postalcode', 'attachments']);
        return view('wsps.commitment-letter')->with(['eoi' => $eoi]);
    }

    public function upload_commitment_letter(Eoi $eoi, Request $request)
    {
        $this->validate_eoi_approved($eoi);
        $request->validate(['attachment' => 'required|file|mimes:pdf,jpg,jpeg,png,docx,doc']);

        $attachment = $eoi->attachments()->where('document_type', 'Commitment Letter')->first();

        if ($attachment) {
            Attachment::remove($attachment);
        }

        $fileName = $this->storeDocument($request->attachment, 'Commitment Letter');

        $eoi->attachments()->create([
            'name' => $fileName,
            'display_name' => 'Commitment Letter',
            'document_type' => 'Commitment Letter',
        ]);

        //todo: send notification to wft if wsp uploaded signed copy and vice-versa

        return back()->with('success', 'Commitment letter uploaded successfully');
    }


    private function validate_eoi_approved(Eoi $eoi)
    {
        if ($eoi->status !== 'WSTF Approved') {
            return back()->withErrors("Expression of Interest must have been approved by Water Trust Fund");
        }
    }

}
