<?php

namespace App\Http\Controllers\API;

use App\Revenue;
use App\Http\Resources\RevenueCollection;
use App\Http\Resources\RevenueResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RevenueAPIController extends Controller
{
    public function index()
    {
        return new RevenueCollection(Revenue::paginate());
    }
 
    public function show(Revenue $revenue)
    {
        return new RevenueResource($revenue->load(['wsp']));
    }

    public function store(Request $request)
    {
        return new RevenueResource(Revenue::create($request->all()));
    }

    public function update(Request $request, Revenue $revenue)
    {
        $revenue->update($request->all());

        return new RevenueResource($revenue);
    }

    public function destroy(Request $request, Revenue $revenue)
    {
        $revenue->delete();

        return response()->noContent();
    }
}
