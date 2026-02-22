<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAbsencePinVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('absence-login');
        }

        $user = auth()->user();
        $securityPin = $user->security_pin;

        if (!$securityPin) {
            if (!$request->routeIs('pin.create', 'pin.create.store', 'absence-logout')) {
                return redirect()->route('pin.create');
            }
        }

        if ($securityPin && !$request->session()->get('pin_verified')) {
            if (!$request->routeIs('pin.verify', 'pin.check', 'absence-logout')) {
                return redirect()->route('pin.verify');
            }
        }

        return $next($request);
    }
}
