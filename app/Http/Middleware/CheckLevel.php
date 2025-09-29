<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLevel
{
    public function handle(Request $request, Closure $next, ...$levels)
    {
        if (Auth::check() && in_array(Auth::user()->level, $levels)) {
            return $next($request);
        }
        abort(403, 'Unauthorized access.');
    }
}