<?php

namespace App\Http\Controllers;

use App\Http\Requests\EoiAttachmentRequest;
use App\Http\Requests\EoiRequest;
use App\Http\Requests\EoiServiceRequest;
use App\Models\Attachment;
use App\Models\Connection;
use App\Models\Eoi;
use App\Models\Estimatedcost;
use App\Models\Operationcost;
use App\Models\Service;
use App\Traits\FilesTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


class EoiController extends Controller
{
    use FilesTrait;

    public function create()
    {
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
            return response()->json(['eoi' => $eoi]);
        }
        return redirect()->back()->with(['eoi' => $eoi]);
    }

    public function attachments(Eoi $eoi)
    {
        $eoi = $eoi->load('attachments');
        $progress = ceil($eoi->attachments->pluck('document_type')->unique()->count()/5 *100);
        return view('eoi.attachments')->with(compact('eoi','progress'));
    }

    public function store_attachments(Eoi $eoi, EoiAttachmentRequest $request)
    {
        if(!$eoi->wsp->users()->pluck('user_id')->contains(auth()->id()))
        {
            abort('403','You do not have the permissions to perform this action');
        }

        $fileName = $this->storeDocument($request->attachment, $request->display_name);

        $eoi->attachments()->create([
            'name' => $fileName,
            'display_name' => $request->display_name,
            'document_type' => $request->document_type,
        ]);

        return view('eoi.attachments')->with(compact('eoi'));
    }

    public function getAttachment($filename)
    {
        $path = storage_path('app/Eoi/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function deleteAttachment(Attachment $attachment)
    {
        Attachment::remove($attachment);

        if(request()->ajax()){
            return response()->json(['message' => "Attachment deleted successfully!"]);
        }

        return redirect()->back()->with(['message' => "Attachment deleted successfully!"]);
    }

    public function preview(Eoi $eoi)
    {
        $eoi = $eoi->load(['wsp', 'services', 'connections', 'estimatedcosts', 'operationcosts']);
        return view('eoi.preview')->with(compact('eoi'));
    }

    public function commitment_letter(Eoi $eoi)
    {
        $eoi = $eoi->load(['wsp','wsp.postalcode']);
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
