<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserPermission {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$perms) {
        if (!auth()->user()->hasAnyPerms(...$perms)) {
            abort(404);
        }
        return $next($request);
    }
}
