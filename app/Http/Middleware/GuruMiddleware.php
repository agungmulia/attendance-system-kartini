<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GuruMiddleware
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
        if (auth()->user() && (((auth()->user()->is_admin) == 0) || ((auth()->user()->is_admin) == 1))) {
            return $next($request);
        }

        return response()->json(['message' => 'Anda tidak mendapat otorisasi untuk mengakses sistem ini guru'], 403);
    }
}