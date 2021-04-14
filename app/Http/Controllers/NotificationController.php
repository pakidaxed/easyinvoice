<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(30);
        Notification::where('user_id', Auth::id())->where('seen', false)->update(['seen' => true]);
        return view('notification.index', ['notifications' => $notifications]);
    }
}
