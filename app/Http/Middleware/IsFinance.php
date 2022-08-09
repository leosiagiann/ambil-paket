<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsFinance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role->name != 'finance') {
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}