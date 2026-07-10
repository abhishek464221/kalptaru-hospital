<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Admin Header Notifications
        View::composer('admin.includes.header', function ($view) {
            $user = Auth::user();
            if ($user) {
                $notifications = Notification::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get();
                $unreadCount = Notification::where('user_id', $user->id)
                    ->where('is_read', false)
                    ->count();
            } else {
                $notifications = collect([]);
                $unreadCount = 0;
            }
            $view->with([
                'notifications' => $notifications,
                'unreadCount' => $unreadCount,
            ]);
        });

        // Frontend Home Page (Departments & Home Doctors)
        View::composer('frontend.pages.index', \App\Http\ViewComposers\FrontendComposer::class);
        View::composer('frontend.layouts.app', \App\Http\ViewComposers\FrontendComposer::class);
    }
}