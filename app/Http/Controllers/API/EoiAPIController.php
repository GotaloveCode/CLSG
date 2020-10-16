<?php

namespace App\Http\Controllers\API;

use App\Eoi;
use App\Http\Resources\EoiCollection;
use App\Http\Resources\EoiResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function store(Request $request)
    {
        return new EoiResource(Eoi::create($request->all()));
    }

    public function update(Request $request, Eoi $eoi)
    {
        $eoi->update($request->all());

        return new EoiResource($eoi);
    }

    public function destroy(Request $request, Eoi $eoi)
    {
        $eoi->delete();

        return response()->noContent();
    }
}
