<?php

namespace App\Http\Controllers\API;

use App\EssentialOperation;
use App\Http\Resources\EssentialOperationCollection;
use App\Http\Resources\EssentialOperationResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EssentialOperationAPIController extends Controller
{
    public function index()
    {
        return new EssentialOperationCollection(EssentialOperation::paginate());
    }
 
    public function show(EssentialOperation $essentialOperation)
    {
        return new EssentialOperationResource($essentialOperation->load(['bcp', 'essentialfunction']));
    }

    public function store(Request $request)
    {
        return new EssentialOperationResource(EssentialOperation::create($request->all()));
    }

    public function update(Request $request, EssentialOperation $essentialOperation)
    {
        $essentialOperation->update($request->all());

        return new EssentialOperationResource($essentialOperation);
    }

    public function destroy(Request $request, EssentialOperation $essentialOperation)
    {
        $essentialOperation->delete();

        return response()->noContent();
    }
}
