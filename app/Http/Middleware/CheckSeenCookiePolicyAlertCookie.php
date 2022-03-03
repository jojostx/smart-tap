<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSeenCookiePolicyAlertCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($request->hasCookie('cookieAlertSeen')) {
            $request->session()->put('cookieAlertSeen', $request->cookie('cookieAlertSeen'));

            return $response;    
        }

        $request->session()->put('cookieAlertSeen', false);

        return $response->cookie('cookieAlertSeen', false, 20160);
    }
}
