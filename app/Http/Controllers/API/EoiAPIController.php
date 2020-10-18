<?php

namespace App\Http\Controllers\API;

use App\Models\Eoi;
use App\Http\Resources\EoiCollection;
use App\Http\Resources\EoiResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EoiAPIController extends Controller
{
    public function index()
    {
        return new EoiCollection(Eoi::paginate());
    }

    public function show(Eoi $eoi)
    {
        return new EoiResource($eoi->load(['wsp', 'services', 'connections', 'estimatedcosts', 'operationcosts']));
    }

//    public function store(Request $request)
//    {
//        return new EoiResource(Eoi::create($request->all()));
//    }
    public function store(Request $request)
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
            'wsp_id' => $request->input('wsp')
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
    public function update(Request $request,Eoi $eoi)
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

    public function destroy(Request $request, Eoi $eoi)
    {
        $eoi->delete();

        return response()->noContent();
    }
}
