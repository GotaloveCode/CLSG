<?php

namespace App\Http\Controllers;

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
                $wsp = auth()->user()->wsps()->first();
                $eoi = $wsp->eois()->first();
                $bcp = $wsp->bcps()->first();
                return view('dashboard.wsp')->with(compact('wsp','eoi','bcp'));
            case 'wstf':
                return view('dashboard.wstf');
            case 'wasreb':
                return view('dashboard.wasreb');
            default:
                return view('dashboard.admin');
        }
    }
}
