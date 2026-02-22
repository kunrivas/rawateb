<?php

namespace App\Http\Controllers\Absence;

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
            return redirect()->route('absence-login');
        }

        return view('absence.pin.pin-verify');
    }
    public function check(Request $request)
{
    if (!auth()->check()) {
        return redirect()->route('absence-login');
    }

    $user = auth()->user();
    $maxAttempts = 3;
    $decaySeconds = 3600;
    $key = 'pin-attempt:' . $user->id;

    if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
        $this->userFailedAttemptLogger($user->id, 'ACCOUNT LOCKED - Too many attempts');

        auth()->logout();
        $request->session()->forget('pin_verified');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('absence-login')->withErrors([
            'pin' => 'تم قفل حسابك مؤقتًا بسبب محاولات متعددة فاشلة. يرجى تسجيل الدخول مرة أخرى بعد ' . RateLimiter::availableIn($key) . ' ثانية.',
        ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    $request->validate(['pin' => 'required|digits:4']);

    if (Hash::check($request->pin, $user->security_pin)) {
        RateLimiter::clear($key);
        $request->session()->put('pin_verified', true);

        return redirect()->route('absence-home');
    }

    $attempts = RateLimiter::hit($key, $decaySeconds);
    $remaining = max($maxAttempts - $attempts, 0);

    if ($attempts >= $maxAttempts) {
        $this->userFailedAttemptLogger($user->id, 'ACCOUNT LOCKED - Too many attempts');

        auth()->logout();
        $request->session()->forget('pin_verified');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('absence-login')->withErrors([
            'pin' => 'تم قفل حسابك مؤقتًا بسبب محاولات متعددة فاشلة. يرجى تسجيل الدخول مرة أخرى بعد ' . RateLimiter::availableIn($key) . ' ثانية.',
        ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    return back()
        ->withErrors(['pin' => 'PIN خاطئ ، باقي ' . $remaining . ' محاولات.'])
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
}

   /*  public function check(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('absence-login');
        }

        $user = auth()->user();
        $key = 'pin-attempt:' . $user->id;

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $this->userFailedAttemptLogger($user->id, 'ACCOUNT LOCKED - Too many attempts');

            auth()->logout();
            $request->session()->forget('pin_verified');
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('absence-login')->withErrors([
                'pin' => 'تم قفل حسابك مؤقتًا بسبب محاولات متعددة فاشلة. يرجى تسجيل الدخول مرة أخرى بعد ' . RateLimiter::availableIn($key) . ' ثانية.',
            ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        }

        $request->validate(['pin' => 'required|digits:4']);

        if (Hash::check($request->pin, $user->security_pin)) {
            RateLimiter::clear($key);
            $request->session()->put('pin_verified', true);

            return redirect()->route('absence-home');
        }

        RateLimiter::hit($key, 3600);

        return back()
            ->withErrors(['pin' => 'PIN خاطئ ، باقي ' . RateLimiter::remaining($key, 3) . ' محاولات.'])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    } */

    public function createPin()
    {
        if (!auth()->check()) {
            return redirect()->route('absence-login');
        }

        return view('absence.pin.pin-create');
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('absence-login');
        }

        $request->validate([
            'pin' => 'required|digits:4|not_in:0000,1111,1234',
        ]);

        $user = User::find(auth()->id());
        $user->security_pin = Hash::make($request->pin);
        $user->save();

        auth()->logout();
        $request->session()->forget('pin_verified');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('absence-login')->with([
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
