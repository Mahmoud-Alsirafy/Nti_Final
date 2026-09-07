<?php

namespace App\Http\Controllers\Google;

use App\Events\GenrateQr;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            // dd($googleUser);

            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name'     => $googleUser->name,
                    'email'    => $googleUser->email,
                    'password' => Hash::make(Str::random(16)),
                    'qr_code'  => (string) Str::uuid(),
                    'type'     => 'user',
                ]);

                event(new GenrateQr($user));
            }

            Auth::login($user);

            if ($user->type === 'admin') {
                return redirect()->route('AdminDashboard');
            }

            return redirect()->route('UserDashboard');
        } catch (Exception $e) {
            \Log::error('Google Auth Error: ' . $e->getMessage());
            // dd($e->getMessage()); // مؤقتاً عشان تشوف الـ error فوراً
            return redirect()->route('login')->with('error', 'Google authentication failed.');
        }
    }
}
