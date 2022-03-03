<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && $request->user()->admin()) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}
