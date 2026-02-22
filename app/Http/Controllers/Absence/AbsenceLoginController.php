<?php

namespace App\Http\Controllers\Absence;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AbsenceLoginController extends Controller
{
    public function login(Request $request)
    {
        Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ])->validate();

        $user = User::where('user_username', $request->username)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['اسم المستخدم غير موجود']);
        }

        $plainPassword = (string) $request->input('password');
        $storedPassword = (string) $user->user_password;
        $isValid = false;

        // 1) Standard hashed password
        if (Hash::isHashed($storedPassword)) {
            $isValid = Hash::check($plainPassword, $storedPassword);
        }

        // 2) Legacy encrypted password (Crypt::encryptString)
        if (!$isValid) {
            try {
                $decrypted = Crypt::decryptString($storedPassword);
                $isValid = ($decrypted === $plainPassword);
            } catch (\Throwable $e) {
                $isValid = false;
            }
        }

        // 3) Legacy encrypted password (Crypt::encrypt)
        if (!$isValid) {
            try {
                $decrypted = Crypt::decrypt($storedPassword);
                $isValid = ((string) $decrypted === $plainPassword);
            } catch (DecryptException $e) {
                $isValid = false;
            }
        }

        // 4) Final fallback for very old plain-text rows
        if (!$isValid) {
            $isValid = hash_equals($storedPassword, $plainPassword);
        }

        // Migrate old formats to hash on successful login
        if ($isValid && !Hash::isHashed($storedPassword)) {
            $user->user_password = Hash::make($plainPassword);
            $user->save();
        }

        if (!$isValid) {
            return redirect()->route('absence-login')
                ->withErrors(['كلمة المرور خاطئة'])
                ->withInput($request->except('password'));
        }

        Auth::login($user);
        $request->session()->forget('pin_verified');

        return redirect()->route('absence-home');
    }
}
