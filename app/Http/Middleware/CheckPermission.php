<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!in_array($request->user()->permission, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
