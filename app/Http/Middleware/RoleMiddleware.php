<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $roles)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // افصل الأدوار المطلوبة في الميدل وير
        $rolesArray = explode('|', $roles);

        // تحقق هل المستخدم يملك أي من هذه الأدوار
        $hasRole = $user->roles()->whereIn('name', $rolesArray)->exists();

        if (!$hasRole) {
            abort(403, 'Access denied');
        }

        return $next($request);
    }
}
