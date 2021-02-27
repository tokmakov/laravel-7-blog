<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserRole {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role) {
        if ( ! auth()->user()->hasRole($role)) {
            abort(404);
        }
        return $next($request);
    }
}
