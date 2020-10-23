<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index()
    {
        return response()->json(auth()->user()->unreadNotifications);
    }

    public function store()
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);
        return response()->json(['message' => 'Marked as read']);
    }

    public function update($id)
    {
        DB::table('notifications')->where('id', $id)->update(['read_at' => now()]);
        return response()->json(['message' => 'Marked as read']);
    }

}
