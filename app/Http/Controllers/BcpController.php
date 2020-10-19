<?php

namespace App\Http\Controllers;

use App\Http\Requests\BcpFormRequest;
use App\Models\Bcp;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
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
        $wsp_id = auth()->user()->wsps()->first()->id;
        $bcp = Bcp::where('wsp_id', $wsp_id)->first();
        if ($bcp) {
            return response()->json([
                'errors' => [['wsp_id' => 'A BCP already exists!']],
                'message' => 'The given field was invalid'
            ],422);
        }

        $bcp = Bcp::create(Arr::except($request->validated(), 'objectives') + [
                'wsp_id' => $wsp_id
            ]);

        foreach ($request->input('objectives') as $objective) {
            $bcp->objectives()->create([
                'description' => $objective['description']
            ]);
        }

        if ($request->ajax()) {
            return response()->json(['message' => 'Business Continuity Plan submitted successfully']);
        }
        return back()->with('success', 'Business Continuity Plan submitted successfully');
    }
}
