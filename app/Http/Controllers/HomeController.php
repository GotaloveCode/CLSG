<?php

namespace App\Http\Controllers;

use App\Models\Bcp;
use App\Models\Eoi;
use App\Models\Erp;
use App\Models\Wsp;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $role = auth()->user()->getRoleNames()->first();
        switch ($role) {
            case 'wsp':
                return view('dashboard.wsp');
//            case 'wstf':
//                return view('dashboard.wstf')->with(compact('wsp_count','eoi_count','bcp_count','erp_count'));
//            case 'wasreb':
//                return view('dashboard.wasreb');
            default:
                $bcp_count = Bcp::count();
                $eoi_count = Eoi::count();
                $erp_count = Erp::count();
                $wsp_count = Wsp::count();
                return view('dashboard.general')->with(compact('wsp_count', 'eoi_count', 'bcp_count', 'erp_count'));
        }
    }
}
