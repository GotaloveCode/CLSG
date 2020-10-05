<?php

namespace App\Http\Controllers\API;

use App\Estimatedcost;
use App\Http\Resources\EstimatedcostCollection;
use App\Http\Resources\EstimatedcostResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EstimatedcostAPIController extends Controller
{
    public function index()
    {
        return new EstimatedcostCollection(Estimatedcost::paginate());
    }
 
    public function show(Estimatedcost $estimatedcost)
    {
        return new EstimatedcostResource($estimatedcost->load(['eois']));
    }

    public function store(Request $request)
    {
        return new EstimatedcostResource(Estimatedcost::create($request->all()));
    }

    public function update(Request $request, Estimatedcost $estimatedcost)
    {
        $estimatedcost->update($request->all());

        return new EstimatedcostResource($estimatedcost);
    }

    public function destroy(Request $request, Estimatedcost $estimatedcost)
    {
        $estimatedcost->delete();

        return response()->noContent();
    }
}
