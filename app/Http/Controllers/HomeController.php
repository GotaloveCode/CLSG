<?php

namespace App\Http\Controllers;

use App\Models\Bcp;
use App\Models\Eoi;
use App\Models\Erp;
use App\Models\Wsp;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $role = auth()->user()->getRoleNames()->first();
        $notifications = auth()->user()->unreadNotifications;
        $notifications_count = $notifications->count();
        $notifications = $notifications->take(5);
        switch ($role) {
            case 'wsp':
                return view('dashboard.wsp')->with(compact('notifications', 'notifications_count'));
            case 'wasreb':
                $bcp_pending = Bcp::ofStatus('Pending')->count();
                $eoi_pending = Eoi::ofStatus('Pending')->count();
                $erp_pending = Erp::ofStatus('Pending')->count();
                $bcp_count = Bcp::count();
                $eoi_count = Eoi::count();
                $erp_count = Erp::count();
                $wsp_count = Wsp::count();
                return view('dashboard.general')
                    ->with(compact('notifications', 'notifications_count', 'bcp_pending', 'eoi_pending', 'erp_pending', 'wsp_count', 'eoi_count', 'bcp_count', 'erp_count'));
            default:
                $bcp_pending = Bcp::ofStatus('WASREB Approved')->count();
                $eoi_pending = Eoi::ofStatus('WASREB Approved')->count();
                $erp_pending = Erp::ofStatus('WASREB Approved')->count();
                $bcp_count = Bcp::count();
                $eoi_count = Eoi::count();
                $erp_count = Erp::count();
                $wsp_count = Wsp::count();

                return view('dashboard.general')
                    ->with(compact('notifications', 'notifications_count', 'bcp_pending', 'eoi_pending', 'erp_pending', 'wsp_count', 'eoi_count', 'bcp_count', 'erp_count'));
        }
    }

    public function clsg()
    {
        return view('clsg');
    }
}
