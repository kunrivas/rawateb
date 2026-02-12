<?php

namespace App\Http\Controllers\Director;

use App\Http\Controllers\Controller;

use App\Jobs\ImportDataJob;
use App\Models\adm;
use App\Models\establishement;
use App\Models\establishment;
use App\Models\testtabe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class DirectorGetwayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        // $referer = $request->header('referer');

        $userId =  $this->decodePID($request->pid);
        Auth::logout();
        $estab_user = $request->estab_user;
        $user =   User::find($userId);

        $establishment = establishment::where("estab_mail_code", $estab_user)->first();
        if ($user->id ==  $establishment->estab_mail_director_id) {

          /* if (!$user->hasRole("director")) {
                return redirect()->back()->withErrors([' ليس لديك الصلاحية للوصول إلى هاته الصفحة لقد تم تسديل بياناتك لمراجعتها']);
            }*/
            Auth::login($user);
            session()->put('establishment',   $establishment);
            return redirect()->route("director-home");
        }
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function test(Request $request)
    {
        ImportDataJob::dispatchAfterResponse();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\adm  $adm
     * @return \Illuminate\Http\Response
     */
    public function show(adm $adm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\adm  $adm
     * @return \Illuminate\Http\Response
     */
    public function edit(adm $adm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\adm  $adm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, adm $adm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\adm  $adm
     * @return \Illuminate\Http\Response
     */
    public function destroy(adm $adm)
    {
        //
    }

    private function decodePID($pid)
    {
        $anchor = env('PID_ANCHOR_KEY', 0);

        if ($anchor < 0) {
            return null;
        }

        if (env('PID_A_VALUE', 0) == 0) {
            return null;
        }

        if (env('PID_B_VALUE', 0) == 0) {
            return null;
        }

        $psc = strtotime(date('Y-m-d h'));

        $anchor_key = $anchor + $psc;

        $anchor_pid = $pid - $anchor_key;

        $anchor_pid = substr($anchor_pid, env('PID_A_VALUE', 0));

        $decoded_pid = substr($anchor_pid, 0, env('PID_B_VALUE', 0));

        if (!empty($decoded_pid)) {
            return $decoded_pid;
        }

        return null;
    }
}
