<?php
// owner:   Laravel Group
//
// Author:   Hamza Abbas Copyright (C) - El Oued 2021 (hamzad3d@gmail.com)
//            Distributed under the Free License of use .
//
// Object     : CustomAuth
//
// Description: a Custom Authentication class do session check
//              every time the servre does request .
//
// Parameters : Request::{$request}, Closure::{$next}
//
// Return     : fnc:Closure
//
// Created    : 2021-11-13 10:56:27AM .

namespace App\Http\Middleware;

use Closure;

class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!session()->has('data')) {
            return redirect()->route('rget_login');
        }
        return $next($request);
    }
}
