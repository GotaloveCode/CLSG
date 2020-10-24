<?php

namespace App\Http\Controllers;

use App\Models\Bcp;
use App\Models\Eoi;
use App\Models\Erp;
use App\Models\Wsp;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {

        $role = auth()->user()->getRoleNames()->first();
        switch ($role) {
            case 'wsp':
                return view('dashboard.wsp');
            default:
                $bcp_count = Bcp::count();
                $eoi_count = Eoi::count();
                $erp_count = Erp::count();
                $wsp_count = Wsp::count();
                return view('dashboard.general')->with(compact('wsp_count', 'eoi_count', 'bcp_count', 'erp_count'));
        }
    }
}
