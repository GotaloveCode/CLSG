<?php

namespace App\Http\Controllers\API;

use App\Wsp;
use App\Http\Resources\WspCollection;
use App\Http\Resources\WspResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WspAPIController extends Controller
{
    public function index()
    {
        return new WspCollection(Wsp::paginate());
    }
 
    public function show(Wsp $wsp)
    {
        return new WspResource($wsp->load(['eois', 'bcps', 'staff', 'revenues', 'essentialsupplies']));
    }

    public function store(Request $request)
    {
        return new WspResource(Wsp::create($request->all()));
    }

    public function update(Request $request, Wsp $wsp)
    {
        $wsp->update($request->all());

        return new WspResource($wsp);
    }

    public function destroy(Request $request, Wsp $wsp)
    {
        $wsp->delete();

        return response()->noContent();
    }
}
