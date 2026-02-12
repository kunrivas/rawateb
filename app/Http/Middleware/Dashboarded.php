<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Establishment;

class Dashboarded
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
        $dashboard = session('data')['currentdashboard'];

        if( empty($dashboard) )  {
            return redirect()->route('rget_home')->with('status', 'لم تسند لك مؤسسة بعد');
        }

        //force user dashboarded to get something done
        if ( !in_array($request->url() , [ route('rget_informations.esatablishmentinformation') , route('rpost_informations.store')]) ) {
            if ( Establishment::select('estab_info_update')
            ->where('estab_mail_code',$dashboard)
            ->first()
            ->estab_info_update != '1' ) {
                return redirect()
                ->route('rget_informations.esatablishmentinformation')
                ->with('status','المطلوب ملء البيانات بعناية للتمكن من الولوج للبريد');
            }
        }

        return $next($request);
    }
}
