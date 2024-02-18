<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function Handle(Request $request, Closure $next)
    {
        //checking if user has admin role
        if (Auth::check()) {
            if (Auth::user()->role_id == '1') {
                return $next($request);
            } else {
                return redirect('/')->with('message', 'Toegang geweigerd! Aangezien u geen beheerder bent');
            }
        }

    }
}
