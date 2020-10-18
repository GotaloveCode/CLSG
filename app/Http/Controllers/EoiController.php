<?php

namespace App\Http\Controllers;

use App\Mail\EoiComment;
use App\Mail\EoiReview;
use App\Http\Requests\EoiCommentRequest;
use App\Http\Requests\EoiRequest;
use App\Http\Requests\EoiReviewRequest;
use App\Models\Connection;
use App\Models\Eoi;
use App\Models\Estimatedcost;
use App\Models\Operationcost;
use App\Models\Service;
use App\Traits\EoiAuthTrait;
use App\Traits\FilesTrait;
use App\Http\Resources\EoiCustomResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use function PHPUnit\Framework\isEmpty;


class EoiController extends Controller
{
    use FilesTrait, EoiAuthTrait;

    public function index()
    {
        if(!request()->ajax()){
            return view('eoi.index');
        }

        $eois = Eoi::query()->select('eois.id', 'fixed_grant', 'variable_grant', 'emergency_intervention_total', 'operation_costs_total', 'wsp_id', 'wsps.name', 'eois.created_at')
            ->with('wsp:id,name');
//        ->ofStatus('published')
        return Datatables::of($eois)
            ->addColumn('action', function ($eoi) {
                return '<a href="' . route("eoi.preview", $eoi->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Review</a>';
            })
            ->make(true);
    }

    public function create()
    {
      if (!isset(auth()->user()->wsps()->first()->pivot->wsp_id)){
          return false;
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

        $wsp = auth()->user()->wsps()->first()->pivot->wsp_id;
       if (Eoi::where('wsp_id',$wsp)->first()) $eoi = json_encode(new EoiCustomResource(Eoi::where('wsp_id',$wsp)->first()));
       else $eoi = json_encode([]);

        return view('eoi.create')->with(compact('services', 'connections', 'estimatedCosts', 'operationCosts','eoi','wsp'));
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
            'wsp_id' => auth()->user()->wsps()->first()->id
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
        return redirect()->back()->with(['eoi' => $eoi]);
    }

    public function preview(Eoi $eoi)
    {
        switch ($eoi->status) {
            case 'WFT Approved':
                $progress = 100;
                break;
            case 'WASREB Approved':
                $progress = 75;
                break;
            case 'Needs Approval':
                $progress = 50;
                break;
            default:
                $progress = 25;
        }

        $eoi = $eoi->load(['wsp', 'services', 'connections', 'estimatedcosts', 'operationcosts']);
        return view('eoi.preview')->with(compact('eoi','progress'));
    }

    public function review(Eoi $eoi, EoiReviewRequest $request)
    {
        if (!auth()->user()->can('review-eoi')) {
            $this->canAccessEoi($eoi);
        }
        $eoi->status = $request->status;
        $eoi->save();

        //todo: notification of action
          Mail::to(auth()->user()->email)->send(new EoiReview());
        $route = route('eoi.preview', $eoi->id);

        if ($request->status == 'WFT Approved') {
            $route = route('eoi.commitment_letter', $eoi->id);
        }

        return response()->json([
            'message' => 'Eoi status changed to ' . $request->status,
            'route' => $route
        ]);
    }

    public function comment(Eoi $eoi, EoiCommentRequest $request)
    {
        if (!auth()->user()->can('comment-eoi')) {
            $this->canAccessEoi($eoi);
        }

        $eoi->comments()->create([
            'description' => $request->description,
            'user_id' => auth()->id()
        ]);
        Mail::to(auth()->user()->email)->send(new EioComment($request->description));
        //todo: notification on activity

        return response()->json(['message' => 'Comment posted successfully']);
    }

    public function commitment_letter(Eoi $eoi)
    {
        if($eoi->status !== 'WFT Approved'){
            return redirect()->back()->withErrors("Expression of Interest must have been approved by Water Trust Fund");
        }
        $eoi = $eoi->load(['wsp', 'wsp.postalcode']);
        return view('wsps.commitment-letter')->with(compact('eoi'));
    }

//    public function services(Eoi $eoi)
//    {
//        $eoi = $eoi->load('services');
//        $services = Cache::rememberForever('services', function () {
//            return Service::select('id', 'name')->get();
//        });
//        $connections = Cache::rememberForever('connections', function () {
//            return Connection::select('id', 'name')->get();
//        });
//        $estimatedCosts = Cache::rememberForever('estimatedCosts', function () {
//            return Estimatedcost::select('id', 'name')->get();
//        });
//        return view('eoi.create_service')->with(compact('services', 'connections', 'eoi', 'estimatedCosts'));
//    }
//
//    public function update_services(EoiServiceRequest $request)
//    {
//        $connections = Cache::rememberForever('connections', function () {
//            return Connection::select('id', 'name')->get();
//        });
//
//        $estimatedCosts = Cache::rememberForever('estimatedCosts', function () {
//            return Estimatedcost::select('id', 'name')->get();
//        });
//
//        $services = collect($request->services);
//        $eoi = Eoi::find($services->first()['eoi_id']);
//        $service_ids = $eoi->services()->pluck('service_id');
//        $services->each(function ($s) use ($service_ids, $eoi) {
//            if ($service_ids->has($s['id'])) {
//                $eoi->services()->updateExistingPivot($s['id'], [
//                    'areas' => $s['areas'],
//                    'total' => $s['total']
//                ]);
//            } else {
//                $eoi->services()->attach($s['id'], [
//                    'areas' => $s['areas'],
//                    'total' => $s['total']
//                ]);
//            }
//        });
//
//        return view('eoi.create_service')->with(compact('services', 'eoi', 'connections', 'estimatedCosts'));
//    }

}
