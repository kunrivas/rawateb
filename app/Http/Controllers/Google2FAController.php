<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FALaravel\Google2FA;

class Google2FAController extends Controller
{
    /**
     * Show the 2FA setup form with QR code.
     */
    public function showSetupForm()
    {
        $user = Auth::user();

        $google2fa = app('pragmarx.google2fa');
        //dd($user);
        // Generate a new secret if the user doesn't have one
        if (!$user->google2fa_secret) {
            $secret = $google2fa->generateSecretKey();
            $user->google2fa_secret = $secret;
            $user->save();
        } else {
            $secret = $user->google2fa_secret;
        }

        // Generate the QR code URL
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        return view('auth.2fa_setup', compact('secret', 'qrCodeUrl'));
    }

    /**
     * Enable 2FA after verifying the OTP from the setup form.
     */
    public function enable2fa(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|numeric',
        ]);

        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');

        // Verify the submitted OTP
        if ($google2fa->verifyKey($user->google2fa_secret, $request->one_time_password)) {
            $user->google2fa_enabled = true;
            $user->save();

            return $this->getRedirectBasedOnUserType($user)->with('success', 'تم تفعيل المصادقة الثنائية بنجاح.');
        } else {
            return redirect()->back()->withErrors(['one_time_password' => 'Invalid verification code. Please try again.']);
        }
    }

    public function disable2fa(Request $request)
    {
        $user = Auth::user();

        // إزالة المفتاح السري
        $user->google2fa_enabled = false;
        $user->google2fa_secret = null;
        $user->save();

        return redirect()->back()->with('success', 'تم تعطيل المصادقة الثنائية بنجاح.');
    }

    /**
     * Show the 2FA verification form during login.
     */
    public function showVerifyForm()
    {
        return view('auth.2fa_verify');
    }

    /**
     * Verify the OTP during login.
     */
    public function verify2fa(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|numeric',
        ]);

        $user = Auth::user();
        //  dd($user);
        $google2fa = app('pragmarx.google2fa');
        // dd($google2fa);
        if ($google2fa->verifyKey($user->google2fa_secret, $request->one_time_password)) {
            // Mark session as 2FA verified
            $request->session()->put('google2fa_verified', true);
            // Dynamic redirect based on user type
            return $this->getRedirectBasedOnUserType($user);
        }

        return redirect()->back()->withErrors(['one_time_password' => 'Invalid verification code. Please try again.']);
    }

    protected function getRedirectBasedOnUserType($user)
    {
        // Adjust these conditions based on your actual user type checking
        if (Auth::user()->hasRole('manager')) {
            return redirect()->route('admin-home');
        } elseif (Auth::user()->hasRole('abs-admin')) {
            return redirect()->route('absence-home');
        }
        /*  elseif (Auth::user()->hasRole('director')) {
             return redirect()->route('');
        }  */

        // Default redirect if no specific role matches
        return redirect()->intended('/');
    }
}
