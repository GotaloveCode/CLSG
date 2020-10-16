<?php

namespace App\Http\Controllers\API;

use App\Models\Bcp;
use App\Http\Resources\BcpCollection;
use App\Http\Resources\BcpResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BcpAPIController extends Controller
{
    public function index()
    {
        return new BcpCollection(Bcp::paginate());
    }

    public function show(Bcp $bcp)
    {
        return new BcpResource($bcp->load(['bcpteams', 'essentialOperations', 'wsp']));
    }

    public function store(Request $request)
    {
        return new BcpResource(Bcp::create($request->all()));
    }

    public function update(Request $request, Bcp $bcp)
    {
        $bcp->update($request->all());

        return new BcpResource($bcp);
    }

    public function destroy(Request $request, Bcp $bcp)
    {
        $bcp->delete();

        return response()->noContent();
    }
}
