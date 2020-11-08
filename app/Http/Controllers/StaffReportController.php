<?php

namespace App\Http\Controllers;

use App\Http\Resources\StaffHealthResource;
use App\Models\BcpChecklist;
use App\Models\StaffHealth;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StaffReportController extends Controller
{

    public function index()
    {
        if (!request()->ajax()) {
            return view('checklists.staff.index');
        }

        $wsp = auth()->user()->wsps()->first();

        if ($wsp) {
            if ($wsp->bcp) {
                $essential = StaffHealth::where('bcp_id', $wsp->bcp->id)->get();
            } else {
                $essential = [];
            }
        } else {
            $essential = StaffHealth::get();
        }

        $staff = StaffHealthResource::collection($essential);

        return Datatables::of($staff)
            ->addColumn('action', function ($staff) {
                return '<a href="' . route("staff-health.show", $staff['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);
    }


    public function create()
    {
        $exiting_staff = StaffHealth::where('bcp_id', auth()->user()->wsps()->first()->bcp->id)->latest()->first();
        $exiting_staff ? $staff = json_encode(new StaffHealthResource($exiting_staff)) : $staff = json_encode([]);
        $items = json_encode(BcpChecklist::all());
        return view("checklists.staff.create", compact("staff", "items"));
    }


    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|in:' . now()->year,
            'month' => 'required|in:' . now()->month . ',' . (now()->month - 1),
            'staff_details' => 'required'
        ]);

        $staff = StaffHealth::create([
            'bcp_id' => auth()->user()->wsps()->first()->bcp->first()->id,
            'staff_details' => json_encode($request->input("staff_details")),
            'month' => $request->month,
            'year' => $request->year,
            'status' => 'Pending'
        ]);
        return response()->json($staff);
    }


    public function show(StaffHealth $staff_health)
    {
        $checklist = BcpChecklist::where("type", "Staff Health Protection")->get();
        $staff = $staff_health;
        $progress = $staff->progress();
        return view("checklists.staff.show", compact("checklist", "staff", "progress"));
    }


    public function update(Request $request, $id)
    {
        //
    }


}
