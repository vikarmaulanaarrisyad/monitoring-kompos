<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // $notifications = Auth::user()->notifications()->whereNull('read_at')->get();
        // $notificationCount = $notifications->count();

        return view('dashboard.index');
    }
}
