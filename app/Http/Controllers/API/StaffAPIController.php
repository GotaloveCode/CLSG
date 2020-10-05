<?php

namespace App\Http\Controllers\API;

use App\Staff;
use App\Http\Resources\StaffCollection;
use App\Http\Resources\StaffResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaffAPIController extends Controller
{
    public function index()
    {
        return new StaffCollection(Staff::paginate());
    }
 
    public function show(Staff $staff)
    {
        return new StaffResource($staff->load(['wsp']));
    }

    public function store(Request $request)
    {
        return new StaffResource(Staff::create($request->all()));
    }

    public function update(Request $request, Staff $staff)
    {
        $staff->update($request->all());

        return new StaffResource($staff);
    }

    public function destroy(Request $request, Staff $staff)
    {
        $staff->delete();

        return response()->noContent();
    }
}
