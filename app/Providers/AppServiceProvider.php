<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Models\Notification;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        URL::forceScheme('https');
        View::composer('*', function ($view) {
            $settings = Setting::pluck('value', 'key')->toArray();
            $view->with('settings', $settings);
        });

        View::composer('admin.layouts.header', function ($view) {
            $unreadCount = Notification::where('user_id', auth()->id())
                ->where('is_read', false)
                ->count();

            $notifications = Notification::where('user_id', auth()->id())
                ->latest()
                ->limit(5)
                ->get();

            $view->with(compact('unreadCount', 'notifications'));
        });
    }
}
