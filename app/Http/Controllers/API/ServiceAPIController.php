<?php

namespace App\Http\Controllers\API;

use App\Service;
use App\Http\Resources\ServiceCollection;
use App\Http\Resources\ServiceResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceAPIController extends Controller
{
    public function index()
    {
        return new ServiceCollection(Service::paginate());
    }
 
    public function show(Service $service)
    {
        return new ServiceResource($service->load(['eois']));
    }

    public function store(Request $request)
    {
        return new ServiceResource(Service::create($request->all()));
    }

    public function update(Request $request, Service $service)
    {
        $service->update($request->all());

        return new ServiceResource($service);
    }

    public function destroy(Request $request, Service $service)
    {
        $service->delete();

        return response()->noContent();
    }
}
