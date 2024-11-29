<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendakiAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('pendaki')->check()) {
            return redirect()->route('pendaki.login');
        }

        return $next($request);
    }
}