<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FarmerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isFarmer()) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Unauthorized access.');
    }
} 