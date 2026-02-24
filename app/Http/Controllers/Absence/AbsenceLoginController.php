<?php

namespace App\Http\Controllers\Absence;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;

class AbsenceLoginController extends Controller
{
    public function login(Request $request)
    {
        $maxAttempts = 3;
        $decaySeconds = 180;
        $username = (string) $request->input('username');
        $key = 'absence-login-attempt:' . strtolower($username) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            return redirect()->route('absence-login')
                ->withErrors(['تم قفل الدخول مؤقتًا. حاول بعد ' . RateLimiter::availableIn($key) . ' ثانية.'])
                ->withInput($request->except('password'));
        }

        Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ])->validate();

        $user = User::where('user_username', $request->username)->first();
        if (!$user) {
            $attempts = RateLimiter::hit($key, $decaySeconds);
            $remaining = max($maxAttempts - $attempts, 0);

            return redirect()->back()->withErrors(['اسم المستخدم غير موجود. باقي ' . $remaining . ' محاولات.']);
        }

        $plainPassword = (string) $request->input('password');
        $storedPassword = (string) $user->user_password;
        $isValid = false;

        if (Hash::isHashed($storedPassword)) {
            $isValid = Hash::check($plainPassword, $storedPassword);
        }

        if (!$isValid) {
            try {
                $decrypted = Crypt::decryptString($storedPassword);
                $isValid = ($decrypted === $plainPassword);
            } catch (\Throwable $e) {
                $isValid = false;
            }
        }

        if (!$isValid) {
            try {
                $decrypted = Crypt::decrypt($storedPassword);
                $isValid = ((string) $decrypted === $plainPassword);
            } catch (DecryptException $e) {
                $isValid = false;
            }
        }

        if (!$isValid) {
            $isValid = hash_equals($storedPassword, $plainPassword);
        }

        if ($isValid && !Hash::isHashed($storedPassword)) {
            $user->user_password = Hash::make($plainPassword);
            $user->save();
        }

        if (!$isValid) {
            $attempts = RateLimiter::hit($key, $decaySeconds);
            $remaining = max($maxAttempts - $attempts, 0);

            return redirect()->route('absence-login')
                ->withErrors(['كلمة المرور خاطئة. باقي ' . $remaining . ' محاولات.'])
                ->withInput($request->except('password'));
        }

        RateLimiter::clear($key);
        Auth::login($user);
        $request->session()->forget('pin_verified');

        return redirect()->route('absence-home');
    }
}
