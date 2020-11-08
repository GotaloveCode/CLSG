<?php

namespace App\Http\Controllers;

use App\Models\WspReporting;
use App\Models\CslgCalculation;
use App\Models\Erp;
use Illuminate\Http\Request;
use App\Http\Resources\CslgResource;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\FilesTrait;
use App\Traits\PeriodTrait;


class ClsgReportController extends Controller
{
    use FilesTrait, PeriodTrait;


    public function index()
    {
        if (!request()->ajax()) {
            return view('checklists.cslg.index');
        }
        $reporting = CslgResource::collection(CslgCalculation::get());

        return Datatables::of($reporting)
            ->addColumn('action', function ($reporting) {
                return '<a href="' . route("cslg-calculation.show", $reporting['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i>View</a>';
            })
            ->make(true);
    }


    public function create()
    {
        $wsp = auth()->user()->wsps()->first();
        $bcp_id = $wsp->bcp->id;
        $exiting_cslg = CslgCalculation::where('bcp_id', $bcp_id)
            ->latest()
            ->first();;
        $exiting_cslg ? $cslg = json_encode(new CslgResource($exiting_cslg)) : $cslg = json_encode([]);

        $operations = WspReporting::select("clsg_total", "operations_costs", "revenue")
            ->where('bcp_id', $bcp_id)
            ->latest()
            ->first();;

        if (!$operations) return redirect()->back()->with('success', 'Please ensure you have created WSP Reporting first');

        $erp = Erp::where('wsp_id', $wsp->id)->first();

        if (!$erp) return redirect()->back()->with('success', 'Please ensure you have created ERP first');
        $grant = $erp->erp_items->sum('cost');

        return view("checklists.cslg.create", compact("cslg", "operations", 'grant'));
    }

    public function show($id)
    {
        $item = CslgCalculation::find($id);
        $operations = WspReporting::with('attachments')->where('bcp_id', auth()->user()->wsps()->first()->bcp->id)->latest()->first();
        if (!$operations) return redirect()->back();
        $cslg = json_encode(new CslgResource($item));

        return view("checklists.cslg.show", compact("cslg", "operations"));
    }

    public function store(Request $request)
    {
        $request['month'] = $this->getMonth();
        $request['year'] = $this->getYear();
        $request['bcp_id'] = auth()->user()->wsps()->first()->bcp->first()->id;
        $cslg = CslgCalculation::create($request->all());
        return response()->json($cslg);
    }

    public function approveCslg(Request $request)
    {
        CslgCalculation::find($request->input("id"))->update($request->except(['month', 'wsp']));
        return response()->json('success');
    }

    public function saveFileDoc($base64_image)
    {
        $fileName = "";
        $type = explode(",", $base64_image)[0];
        // your base64 encoded
        @list($type, $file_data) = explode(';', $base64_image);
        @list(, $file_data) = explode(',', $file_data);
        if ($type == "data:application/pdf") {
            $fileName = Str::random(6) . '' . date('s') . gettimeofday()['usec'] . '.pdf';
            \Storage::disk('local')->put($fileName, base64_decode($file_data));
        } else {
            $fileName = Str::random(6) . '' . date('s') . gettimeofday()['usec'] . '.docx';
            \Storage::disk('local')->put($fileName, base64_decode($file_data));
        }
        return $fileName;
    }
}
