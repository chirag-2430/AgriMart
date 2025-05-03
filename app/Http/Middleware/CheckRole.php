<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user() || !$request->user()->role || $request->user()->role->name !== $role) {
            return redirect('/home')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
