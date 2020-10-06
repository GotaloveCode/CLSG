<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\Service;
use Illuminate\Support\Facades\Cache;


class EoiController extends Controller
{
    public function create()
    {
        $services  = Cache::rememberForever('services', function () {
                return Service::all();
            });
        $connections  = Cache::rememberForever('connections', function () {
            return Connection::all();
        });
        return view('eoi')->with(compact('services','connections'));
    }
}
