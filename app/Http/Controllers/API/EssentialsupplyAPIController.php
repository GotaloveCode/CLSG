<?php

namespace App\Http\Controllers\API;

use App\Essentialsupply;
use App\Http\Resources\EssentialsupplyCollection;
use App\Http\Resources\EssentialsupplyResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EssentialsupplyAPIController extends Controller
{
    public function index()
    {
        return new EssentialsupplyCollection(Essentialsupply::paginate());
    }
 
    public function show(Essentialsupply $essentialsupply)
    {
        return new EssentialsupplyResource($essentialsupply->load(['wsps']));
    }

    public function store(Request $request)
    {
        return new EssentialsupplyResource(Essentialsupply::create($request->all()));
    }

    public function update(Request $request, Essentialsupply $essentialsupply)
    {
        $essentialsupply->update($request->all());

        return new EssentialsupplyResource($essentialsupply);
    }

    public function destroy(Request $request, Essentialsupply $essentialsupply)
    {
        $essentialsupply->delete();

        return response()->noContent();
    }
}
