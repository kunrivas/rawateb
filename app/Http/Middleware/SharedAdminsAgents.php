<?php

namespace App\Http\Middleware;

use Closure;

class SharedAdminsAgents
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
        //
        // this middleware allows only Administration Agents of 
        // the direction .
        // MODERATOR : main moderators
        // ADMIN : admins of job  

        $profession_code = session('data')['profession_code']; 

        if(!in_array($profession_code,['TREASURE','CRDDP','FINSP','PAINSP','FINSP'])){
            return redirect()->route('rget_home');
        } 

        return $next($request);
    }
}
