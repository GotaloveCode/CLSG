<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\StaffHealthResource;
use App\Models\BcpChecklist;
use App\Models\StaffHealth;
use App\Traits\SendMailNotification;
use App\Traits\StaffHealthReportAuthTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StaffReportController extends Controller
{
    use StaffHealthReportAuthTrait;

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
        $items = json_encode(BcpChecklist::where('type', 'Staff Health Protection')->get());
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
        $checklist = BcpChecklist::select('id', 'name')->where("type", "Staff Health Protection")->get();
        $staff = $staff_health;
        $progress = $staff->progress();
        return view("checklists.staff.show", compact("checklist", "staff", "progress"));
    }


    public function update(Request $request, StaffHealth $staff_health)
    {
        $staff_health->update([
            'staff_details' => json_encode($request->input("staff_details")),
            'status' => 'Pending'
        ]);
        return response()->json($staff_health);
    }

    public function review(StaffHealth $staff_health, Request $request)
    {
        $this->canAccessStaffHealthReport($staff_health);
        $staff_health->status = $request->status;
        $staff_health->save();
        $wsp = $staff_health->bcp->wsp;

        $route = route('staff-health.show', $staff_health->id);
        SendMailNotification::postReview($request->status, $wsp->id, $route, $wsp->name . ' Staff Health Protection Report Review');

        return response()->json([
            'message' => 'Staff Health Protection Report status changed to ' . $request->status,
            'route' => $route
        ]);
    }

    public function comment(StaffHealth $staff_health, CommentRequest $request)
    {
        $this->canAccessStaffHealthReport($staff_health);

        $staff_health->comments()->create([
            'description' => $request->description,
            'user_id' => auth()->id()
        ]);
        $wsp = $staff_health->bcp->wsp;

        $route = route('staff-health.show', $staff_health->id);
        SendMailNotification::postComment($request->description, $staff_health->status, $wsp->id, $route, $wsp->name . ' Staff Health Protection Reporting Comment');

        return response()->json(['message' => 'Comment posted successfully']);
    }
}
