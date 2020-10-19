<?php

namespace App\Http\Controllers;

use App\Http\Requests\BcpFormRequest;
use App\Models\Bcp;
use App\Models\Operationcost;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
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
        $wsp = auth()->user()->wsps()->first();
        $operation_costs = $wsp->eois()->first()->operationcosts()->get();
        $operation_cost_fields = Cache::rememberForever('operationCosts', function () {
            return Operationcost::select('id', 'name')->get();
        });
        return view('bcps.create')->with(compact( 'operation_cost_fields','operation_costs'));
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

        $bcp = Bcp::create(Arr::except($request->validated(), ['objectives','strategic_plans']) + [
                'wsp_id' => $wsp_id
            ]);

        foreach ($request->input('objectives') as $objective) {
            $bcp->objectives()->create([
                'description' => $objective['description']
            ]);
        }

        foreach ($request->input('operation_costs') as $operation_cost) {
            $bcp->operationcosts()->attach($operation_cost['operationcost_id'], [
                'unit_rate' => $operation_cost['unit_rate'],
                'quantity' => $operation_cost['quantity'],
                'total' => $operation_cost['total'],
            ]);
        }

        if ($request->ajax()) {
            return response()->json(['message' => 'Business Continuity Plan submitted successfully']);
        }
        return back()->with('success', 'Business Continuity Plan submitted successfully');
    }
}
