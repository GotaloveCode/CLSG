<?php

namespace App\Http\Controllers;

use App\Http\Requests\BcpFormRequest;
use App\Models\Bcp;
use Yajra\DataTables\Facades\DataTables;

class BcpController extends Controller
{
    public function index()
    {
        if (!request()->ajax()) {
            return view('bcps.index');
        }

        return Datatables::of(Bcp::query())
            ->addColumn('action', function ($bcp) {
                return '<a href="' . route("bcps.show", $bcp->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);
    }

    public function create()
    {
        return view('bcps.create');
    }

    public function store(BcpFormRequest $request)
    {
        $request->validate(['wsp_id' => 'unique:bcps,wsp_id']);
        Bcp::create($request->all());

        if ($request->ajax()) {
            return response()->json(['message' => 'Business Continuity Plan submitted successfully']);
        }
        return back()->with('success', 'Business Continuity Plan submitted successfully');
    }
}
