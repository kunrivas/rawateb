<?php

namespace App\Http\Controllers\Admin;

use App\Models\adm;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

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
        if (is_null($user)) {
            return redirect()->back()->withErrors(['اسم المستخدم غير موجود']);
        }
     //   dd(Crypt::decrypt($user->user_password), $request->input('password'), Crypt::decrypt($user->user_password) === $request->input('password'));
        // if (Crypt::decrypt($user->user_password) !== $request->input('password')) {
        //     return redirect()->back()->withErrors(['كلمة المرور خاطئة']);
        // }
        if (!Hash::check($request->input('password'), $user->user_password)) {
            return redirect()->back()->withErrors(['كلمة المرور خاطئة']);
        }


         if (!($user->hasRole('manager') || $user->hasRole('printer'))) {
            return redirect()->back()->withErrors([' ليس لديك الصلاحية للوصول إلى هاته الصفحة لقد تم تسديل بياناتك لمراجعتها']);
        }
        Auth::login($user);
        $request->session()->forget('admin_pin_verified');
        //dd($user->roles);

        return redirect()->route("admin-home");

    }
     public function logout()
    {
        Auth::logout();
        return redirect()->route('admin-login');
    }
}
















