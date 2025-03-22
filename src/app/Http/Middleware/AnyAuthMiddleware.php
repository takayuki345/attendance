<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnyAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check() || Auth::guard('web')->check()) {
            if (Auth::guard('web')->check() && !Auth::guard('web')->user()->hasVerifiedEmail()) {
                return redirect(route('verification.notice'));
            }
            return $next($request);
        }

        return redirect('/login');
    }
}
