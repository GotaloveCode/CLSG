<?php

namespace App\Http\Controllers\API;

use App\Operationcost;
use App\Http\Resources\OperationcostCollection;
use App\Http\Resources\OperationcostResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OperationcostAPIController extends Controller
{
    public function index()
    {
        return new OperationcostCollection(Operationcost::paginate());
    }
 
    public function show(Operationcost $operationcost)
    {
        return new OperationcostResource($operationcost->load(['eois']));
    }

    public function store(Request $request)
    {
        return new OperationcostResource(Operationcost::create($request->all()));
    }

    public function update(Request $request, Operationcost $operationcost)
    {
        $operationcost->update($request->all());

        return new OperationcostResource($operationcost);
    }

    public function destroy(Request $request, Operationcost $operationcost)
    {
        $operationcost->delete();

        return response()->noContent();
    }
}
