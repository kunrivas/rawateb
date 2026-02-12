<?php

namespace App\Http\Middleware;
use Closure;


class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!$request->user() || !$request->user()->hasRole(...$roles)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
