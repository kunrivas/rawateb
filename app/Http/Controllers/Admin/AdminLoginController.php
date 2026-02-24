<?php

namespace App\Http\Controllers\Admin;

use App\Models\adm;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
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
        $maxAttempts = 3;
        $decaySeconds = 180;
        $username = (string) $request->input('username');
        $key = 'manager-login-attempt:' . strtolower($username) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            return redirect()->route('admin-login')
                ->withErrors(['تم قفل الدخول مؤقتًا. حاول بعد ' . RateLimiter::availableIn($key) . ' ثانية.'])
                ->withInput($request->except('password'));
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->except('password'));
        }

        $user = User::where('user_username', $request->username)->first();
        if (is_null($user)) {
            $attempts = RateLimiter::hit($key, $decaySeconds);
            $remaining = max($maxAttempts - $attempts, 0);

            return redirect()->back()->withErrors(['اسم المستخدم غير موجود. باقي ' . $remaining . ' محاولات.']);
        }

        // if (Crypt::decrypt($user->user_password) !== $request->input('password')) {
        //     return redirect()->back()->withErrors(['كلمة المرور خاطئة']);
        // }
        if (!Hash::check($request->input('password'), $user->user_password)) {
            $attempts = RateLimiter::hit($key, $decaySeconds);
            $remaining = max($maxAttempts - $attempts, 0);

            return redirect()->back()->withErrors(['كلمة المرور خاطئة. باقي ' . $remaining . ' محاولات.']);
        }

        if (!($user->hasRole('manager') || $user->hasRole('printer'))) {
            $attempts = RateLimiter::hit($key, $decaySeconds);
            $remaining = max($maxAttempts - $attempts, 0);

            return redirect()->back()->withErrors(['ليس لديك الصلاحية للوصول إلى هذه الصفحة. باقي ' . $remaining . ' محاولات.']);
        }

        RateLimiter::clear($key);
        Auth::login($user);
        $request->session()->forget('admin_pin_verified');

        return redirect()->route('admin-home');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin-login');
    }
}
