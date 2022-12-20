<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{

    public function handle(Request $request, Closure $next)
    {
        $user= Auth()->user()->role;

        if ($user == "admin") {
            return $next($request);
        }
       return response()->json('Your account is not admin');
    }
}
