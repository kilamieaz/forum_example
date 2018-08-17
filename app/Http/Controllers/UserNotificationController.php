<?php

namespace App\Http\Controllers;

use App\User;

class UserNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return auth()->user()->unreadNotifications;
    }

    public function destroy(User $user, $notificationId)
    {
        $user->notifications()->find($notificationId)->markAsRead();
    }
}
