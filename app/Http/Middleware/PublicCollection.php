<?php

namespace App\Http\Middleware;

use App\Models\Collection;
use App\Models\UserCollection;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicCollection
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
        if ($request->status == "public")
            return $next($request);
        else {
            $has_user = UserCollection::where('collection_id', $request->collection_id)->where('user_id', $request->user_id)->first();
            $collection = UserCollection::where('collection_id', $request->collection_id)->where('property', 'owner')->value('user_id');
            if (Auth::id() == $collection && !$has_user) {
                return $next($request);
            }

        }
    }
}
