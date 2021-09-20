<?php

namespace App\Http\Controllers\Front\Notifications;

use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{
    public function list()
    {
        return view('pages.notifications.inbox');
    }

    public function show(string $id)
    {
        return view('pages.notifications.inbox');
    }
}
