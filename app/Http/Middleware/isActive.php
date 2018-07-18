<?php

namespace App\Http\Middleware;

use Closure;

class isActive
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
        if (!empty($request->user()) && !$request->user()->active) {
            auth()->logout();
            $request->session()->invalidate();
            $error = __('messages.inactive');
            return redirect()->route('login')->withErrors($error);
        }
        return $next($request);
    }
}
