<?php

namespace App\Http\Controllers\API;

use App\Models\Bcpteam;
use App\Http\Resources\BcpteamCollection;
use App\Http\Resources\BcpteamResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BcpteamAPIController extends Controller
{
    public function index()
    {
        return new BcpteamCollection(Bcpteam::paginate());
    }

    public function show(Bcpteam $bcpteam)
    {
        return new BcpteamResource($bcpteam->load(['bcp']));
    }

    public function store(Request $request)
    {
        return new BcpteamResource(Bcpteam::create($request->all()));
    }

    public function update(Request $request, Bcpteam $bcpteam)
    {
        $bcpteam->update($request->all());

        return new BcpteamResource($bcpteam);
    }

    public function destroy(Request $request, Bcpteam $bcpteam)
    {
        $bcpteam->delete();

        return response()->noContent();
    }
}
