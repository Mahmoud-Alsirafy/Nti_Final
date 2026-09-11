<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\HandelQrCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    use HandelQrCode;
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login via scanned QR code or token POST.
     */
    public function loginPost(Request $request)
    {
        $token = $request->input('qr_code') ?? $request->input('token');

        if (empty($token)) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please provide or scan a valid QR code.',
                ], 422);
            }
            return redirect()->route('login')->withErrors(['error' => 'Please provide or scan a valid QR code.']);
        }

        return $this->login($token);
    }

    /**
     * Resend user's login QR code to their registered email.
     */
    public function resendQr(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('status', 'If an account exists with this email, your login QR code has been dispatched.');
        }

        if (empty($user->qr_code)) {
            $user->qr_code = (string) \Illuminate\Support\Str::uuid();
            $user->save();
        }

        try {
            $user->notify(new \App\Notifications\SendQr());
            return back()->with('status', "Your login QR code has been sent to {$user->email}! Please check your inbox or Mailtrap.");
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => 'Mail delivery error: ' . $e->getMessage()]);
        }
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();


        return redirect()->intended(route('Profile.index', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
