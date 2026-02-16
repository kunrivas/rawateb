<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Models\adm;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class AdminLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "username" => "required",
            "password" => "required",

        ]);
        $user = User::where('user_username', $request->username)->first();
        // dd($user);
        if (is_null($user)) {
            return redirect()->back()->withErrors(['اسم المستخدم غير موجود']);
        }

        // if (Crypt::decrypt($user->user_password) !== $request->input('password')) {
        //     return redirect()->back()->withErrors(['كلمة المرور خاطئة']);
        // }
        if (!Hash::check($request->input('password'), $user->user_password)) {
            return redirect()->back()->withErrors(['كلمة المرور خاطئة']);
        }


        if (!$user->hasRole("abs-admin")) {
            return redirect()->back()->withErrors([' ليس لديك الصلاحية للوصول إلى هاته الصفحة لقد تم تسديل بياناتك لمراجعتها']);
        }
        
        //two factor of email 
      /*   if ($user->two_factor_enabled) {          
            Auth::login($user);
            $user->generateTwoFactorCode(); // (We’ll add this method in the User model next)
            return redirect()->route("twoFactor.index");
        } */

         // two factor of google authenticator
        // Clear any previous 2FA verification
        $request->session()->forget('google2fa_verified');
        if ($user->google2fa_enabled) {
           // dd($user);
            Auth::login($user);
            return redirect()->route('google2fa.verify');
        }

        Auth::login($user);
        return redirect()->route("admin-home");
    }
}
