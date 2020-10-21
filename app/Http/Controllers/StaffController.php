<?php

namespace App\Http\Controllers;


use App\Http\Requests\StaffRequest;
use App\Http\Resources\StaffCollection;
use App\Http\Resources\StaffResource;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class StaffController extends Controller
{
    public function index()
    {
        if (!request()->ajax()) {
            return view('staff.index');
        }

        $staff = Staff::query()->with('wsp:id,name')->select('staff.*');

        if (auth()->user()->hasRole('wsp')) {
            $staff = $staff->where('wsp_id', auth()->user()->wsps()->first()->id);
        }

        return Datatables::of($staff)
            ->addColumn('name', function ($row) {
                return $row->firstname . " " . $row->lastname;
            })
            ->filterColumn('name', function ($query, $keyword) {
                $query->whereRaw("CONCAT(staff.firstname,' ',staff.lastname) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('action', function ($staff) {
                return '<a href="' . route("staff.show", $staff->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> View</a>';
            })
            ->make(true);
    }

    public function show(Staff $staff)
    {
        return view('staff.show')->with(compact('staff'));
    }

    public function create()
    {
        $wsp = auth()->user()->wsps()->first();
        if (!$wsp) {
            abort('403', 'Only WSPs can create staff');
        }
        $wsp_id = $wsp->id;
        $staff = null;
        return view('staff.create')->with(compact('wsp_id'));
    }

    public function store(StaffRequest $request)
    {
        $staff = Staff::create($request->all());
        return response()->json(['message' => "Staff " . $staff->firstname . " created successfully"]);
    }

    public function update(StaffRequest $request, Staff $staff)
    {
        $staff->update($request->all());

        return new StaffResource($staff);
    }

    public function destroy(Request $request, Staff $staff)
    {
        $staff->delete();
        return response()->json(['message' => "Staff deleted successfully"]);
    }
}
