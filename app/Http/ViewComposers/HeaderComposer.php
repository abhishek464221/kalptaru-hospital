<?php

namespace App\Http\ViewComposers;

use App\Models\Notification;
use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view)
    {
        $user = auth()->user();
        if ($user) {
            $notifications = Notification::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            $unreadCount = Notification::where('user_id', $user->id)
                ->where('is_read', false)
                ->count();

            $view->with('notifications', $notifications)
                 ->with('unreadCount', $unreadCount);
        } else {
            $view->with('notifications', collect([]))
                 ->with('unreadCount', 0);
        }
    }
}