<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\BcpChecklist;
use App\Models\BcpMonthlyReport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use \App\Exports\InvoicesExport;
use App\Http\Resources\BcpChecklistResource;


class ReportsController extends Controller
{

    public function index(){
     return view("checklists.index");
    }

    public function checklist()
    {
    return response()->json(BcpChecklist::all());
    }

    public function saveChecklist(Request $request)
    {
       $bcp = BcpMonthlyReport::create([
            'essential'=>json_encode($request->input("essential")),
            'customer'=>json_encode($request->input("customer")),
            'staff'=>json_encode($request->input("staff")),
            'communication'=>json_encode($request->input("communication")),
            'month' =>   $request->input("month"),
            'year' =>   $request->input("year"),
        ]);
       return response()->json($bcp);
    }

    public function getChecklist(Request $request)
    {
        $bcp = BcpMonthlyReport::where("month",$request->get("month"))->where("year",$request->get("year"))->first();
       if ($bcp) $bcp = new BcpChecklistResource($bcp);
       else $bcp = [];
        return response()->json($bcp);
    }
}
