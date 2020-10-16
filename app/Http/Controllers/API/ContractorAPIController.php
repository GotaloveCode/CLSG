<?php

namespace App\Http\Controllers\API;

use App\Contractor;
use App\Http\Resources\ContractorCollection;
use App\Http\Resources\ContractorResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContractorAPIController extends Controller
{
    public function index()
    {
        return new ContractorCollection(Contractor::paginate());
    }
 
    public function show(Contractor $contractor)
    {
        return new ContractorResource($contractor->load(['essentialsupplyWsps']));
    }

    public function store(Request $request)
    {
        return new ContractorResource(Contractor::create($request->all()));
    }

    public function update(Request $request, Contractor $contractor)
    {
        $contractor->update($request->all());

        return new ContractorResource($contractor);
    }

    public function destroy(Request $request, Contractor $contractor)
    {
        $contractor->delete();

        return response()->noContent();
    }
}
