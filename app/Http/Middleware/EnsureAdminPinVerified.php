<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminPinVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('admin-login');
        }

        $user = auth()->user();
        $securityPin = $user->security_pin;

        if (!$securityPin) {
            if (!$request->routeIs('admin.pin.create', 'admin.pin.create.store', 'admin-logout')) {
                return redirect()->route('admin.pin.create');
            }
        }

        if ($securityPin && !$request->session()->get('admin_pin_verified')) {
            if (!$request->routeIs('admin.pin.verify', 'admin.pin.check', 'admin-logout')) {
                return redirect()->route('admin.pin.verify');
            }
        }

        return $next($request);
    }
}
