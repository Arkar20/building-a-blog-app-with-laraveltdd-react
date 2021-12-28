<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationThreadController extends Controller
{
    public function destroy ($notificationid)
    {
        auth()->user()->unreadNotifications()->find($notificationid)->delete();

        return back();
    }
}
