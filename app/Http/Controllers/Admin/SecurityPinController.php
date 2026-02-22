<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class SecurityPinController extends Controller
{
    public function showVerifyForm()
    {
        if (!auth()->check()) {
            return redirect()->route('admin-login');
        }

        return view('admin.pin.pin-verify');
    }

    public function check(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('admin-login');
        }

        $user = auth()->user();
        $maxAttempts = 3;
        $decaySeconds = 3600;
        $key = 'admin-pin-attempt:' . $user->id;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $this->userFailedAttemptLogger($user->id, 'ACCOUNT LOCKED - Too many attempts');

            auth()->logout();
            $request->session()->forget('admin_pin_verified');
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin-login')->withErrors([
                'pin' => 'تم قفل حسابك مؤقتًا بسبب محاولات متعددة فاشلة. يرجى تسجيل الدخول مرة أخرى بعد ' . RateLimiter::availableIn($key) . ' ثانية.',
            ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        }

        $request->validate(['pin' => 'required|digits:4']);

        if (Hash::check($request->pin, $user->security_pin)) {
            RateLimiter::clear($key);
            $request->session()->put('admin_pin_verified', true);

            return redirect()->route('admin-home');
        }

        $attempts = RateLimiter::hit($key, $decaySeconds);
        $remaining = max($maxAttempts - $attempts, 0);

        if ($attempts >= $maxAttempts) {
            $this->userFailedAttemptLogger($user->id, 'ACCOUNT LOCKED - Too many attempts');

            auth()->logout();
            $request->session()->forget('admin_pin_verified');
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin-login')->withErrors([
                'pin' => 'تم قفل حسابك مؤقتًا بسبب محاولات متعددة فاشلة. يرجى تسجيل الدخول مرة أخرى بعد ' . RateLimiter::availableIn($key) . ' ثانية.',
            ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        }

        return back()
            ->withErrors(['pin' => 'PIN خاطئ ، باقي ' . $remaining . ' محاولات.'])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    public function createPin()
    {
        if (!auth()->check()) {
            return redirect()->route('admin-login');
        }

        return view('admin.pin.pin-create');
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('admin-login');
        }

        $request->validate([
            'pin' => 'required|digits:4|not_in:0000,1111,1234',
        ]);

        $user = User::find(auth()->id());
        $user->security_pin = Hash::make($request->pin);
        $user->save();

        auth()->logout();
        $request->session()->forget('admin_pin_verified');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin-login')->with([
            'message' => 'تم إنشاء PIN بنجاح. يرجى تسجيل الدخول مرة أخرى باستخدام PIN الجديد الخاص بك.',
        ]);
    }

    private function userFailedAttemptLogger($userid, $reason)
    {
        $ipAddress = request()->header('X-Forwarded-For')
            ? explode(',', request()->header('X-Forwarded-For'))[0]
            : request()->ip();

        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/users_attempts.log'),
        ])->info("User ID: $userid | Reason: $reason | IP: $ipAddress | UA: " . request()->userAgent());
    }
}
