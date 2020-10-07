<?php

namespace App\Http\Controllers;

use App\Http\Requests\EoiRequest;
use App\Http\Requests\EoiServiceRequest;
use App\Models\Connection;
use App\Models\Eoi;
use App\Models\Service;
use Illuminate\Support\Facades\Cache;


class EoiController extends Controller
{


    public function create()
    {
        return view('eoi.create');
    }

    public function store(EoiRequest $request)
    {
        $eoi = new Eoi();
        $eoi->fill($request->all() + [
                'date' => now(),
                'months' => 3,
                'wsp_id' => auth()->user()->wsps()->first()->id
            ]);
        $eoi->save();
        if ($request->ajax()) {
            return response()->json(['eoi' => $eoi]);
        }
        return redirect()->back()->with(['eoi' => $eoi]);
    }

    public function services(Eoi $eoi)
    {
        $eoi = $eoi->load('services');
        $services = Cache::rememberForever('services', function () {
            return Service::all();
        });
        $connections = Cache::rememberForever('connections', function () {
            return Connection::all();
        });
        return view('eoi.create_service')->with(compact('services', 'connections', 'eoi'));
    }

    public function update_services(EoiServiceRequest $request)
    {
        $services = collect($request->services);
        $eoi_id = $services->first()['eoi_id'];
        $eoi = Eoi::find($eoi_id);
        $service_ids = $eoi_id->services()->pluck('service_id');
        $services->each(function ($s) use ($service_ids, $eoi) {
            if ($service_ids->contain($s['id'])) {
                $eoi->services()->updateExistingPivot($s['id'], [
                    'areas' => $s['areas'],
                    'total' => $s['total']
                ]);
            }else{
                $eoi->services()->save($s['id'], [
                    'areas' => $s['areas'],
                    'total' => $s['total']
                ]);
            }
        });

        return view('eoi.create_service')->with(compact('services', 'connections', 'eoi'));
    }

}
