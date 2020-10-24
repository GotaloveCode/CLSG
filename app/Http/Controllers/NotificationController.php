<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = auth()->user()->unreadNotifications;
        if(!$request->ajax()){
            return view('notifications')->with(compact('notifications'));
        }
        $count = $notifications->count();
        if($request->has('limit')){
            $notifications = $notifications->take($request->input('limit'));
        }
        return response()->json(['notifications'=>  $notifications,'count' => $count]);
    }

    public function store(Request $request)
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);
        if(!$request->ajax()){
            return back()->with(['success' => 'Marked all as read']);
        }
        return response()->json(['message' => 'Marked as read']);
    }

    public function update($id)
    {
        DB::table('notifications')->where('id', $id)->update(['read_at' => now()]);
        return response()->json(['message' => 'Marked as read']);
    }

}
