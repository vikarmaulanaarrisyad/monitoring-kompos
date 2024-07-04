<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead(Request $request)
    {
        $notification = auth()->user()->notifications()->find($request->id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['status' => 'success', 'message' => 'Notification marked as read.']);
        }

        return response()->json(['status' => 'error', 'message' => 'Notification not found.'], 404);
    }

    public function getNotifications()
    {
        $notifications = auth()->user()->notifications()->whereNull('read_at')->get();

        return response()->json($notifications);
    }

    public function countUnread()
    {
        $count = Auth::user()->unreadNotifications()->count();
        return response()->json(['count' => $count]);
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'All notifications have been marked as read.');
    }
}
