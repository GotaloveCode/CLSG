<?php

namespace App\Http\Controllers\API;

use App\Models\Objective;
use App\Http\Resources\ObjectiveCollection;
use App\Http\Resources\ObjectiveResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BcpteamAPIController extends Controller
{
    public function index()
    {
        return new ObjectiveCollection(Objective::paginate());
    }

    public function show(Objective $bcpteam)
    {
        return new ObjectiveResource($bcpteam->load(['bcp']));
    }

    public function store(Request $request)
    {
        return new ObjectiveResource(Objective::create($request->all()));
    }

    public function update(Request $request, Objective $bcpteam)
    {
        $bcpteam->update($request->all());

        return new ObjectiveResource($bcpteam);
    }

    public function destroy(Request $request, Objective $bcpteam)
    {
        $bcpteam->delete();

        return response()->noContent();
    }
}
