<?php

namespace App\Http\Middleware;

use App\Models\UserCollection;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class collectionOwner
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $owner = UserCollection::where('collection_id', '=', $request->collection_id)->where('property', '=', 'owner')->first();
        if (Auth::id() == $owner->user_id)
            return $next($request);
    }
}
