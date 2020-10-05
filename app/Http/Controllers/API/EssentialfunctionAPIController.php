<?php

namespace App\Http\Controllers\API;

use App\Essentialfunction;
use App\Http\Resources\EssentialfunctionCollection;
use App\Http\Resources\EssentialfunctionResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EssentialfunctionAPIController extends Controller
{
    public function index()
    {
        return new EssentialfunctionCollection(Essentialfunction::paginate());
    }
 
    public function show(Essentialfunction $essentialfunction)
    {
        return new EssentialfunctionResource($essentialfunction->load(['essentialOperations']));
    }

    public function store(Request $request)
    {
        return new EssentialfunctionResource(Essentialfunction::create($request->all()));
    }

    public function update(Request $request, Essentialfunction $essentialfunction)
    {
        $essentialfunction->update($request->all());

        return new EssentialfunctionResource($essentialfunction);
    }

    public function destroy(Request $request, Essentialfunction $essentialfunction)
    {
        $essentialfunction->delete();

        return response()->noContent();
    }
}
