<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TrackUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {

            Cache::put(
                'user-is-online-' . Auth::id(),
                true,
                now()->addMinutes(2)
            );

            Auth::user()->update([
                'last_seen' => now()
            ]);
        }

        return $next($request);
    }
}