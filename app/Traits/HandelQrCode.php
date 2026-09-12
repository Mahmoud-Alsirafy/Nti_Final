<?php

namespace App\Traits;

use App\Models\User;
use App\Notifications\SendQr as SendQrNotification;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandelQrCode
{
    /**
     * Generate QR code binary image (PNG).
     */
    public function generateQrCode(string $data, int $size = 300, int $margin = 10): string
    {
        $writer = new PngWriter();
        $qrCode = new QrCode(
            data: $data,
            size: $size,
            margin: $margin,
        );

        return 'data:image/png;base64,' . base64_encode($writer->write($qrCode)->getString());
    }

    /**
     * Generate and store QR code image to storage disk.
     */
    public function storeQrCode(string $data, ?string $filename = null, string $disk = 'public'): string
    {
        $filename = $filename ?? $data;
        $qrImage = $this->generateQrCode($data);
        $path = "qrcodes/{$filename}.png";

        Storage::disk($disk)->put($path, $qrImage);

        return $path;
    }

    /**
     * Generate QR, store to disk, and send to user email.
     */
    public function sendQr(User $user): void
    {
        $this->sendQrToEmail($user);
    }

    /**
     * Send stored QR code to user email.
     */
    public function sendQrToEmail(User $user): void
    {
        if (empty($user->qr_code)) {
            $user->qr_code = (string) Str::uuid();
            $user->save();
        }

        // مش محتاج تحفظ على الـ disk خالص
        $user->notify(new SendQrNotification());
    }

    /**
     * Login user via QR token or scanned QR URL.
     */
    public function login(string $token)
    {
        $token = trim($token);

        // If scanned text is a URL, extract the token from the path or query
        if (str_contains($token, '/')) {
            $parts = explode('/', rtrim($token, '/'));
            $token = end($parts);
        }

        $user = User::where('qr_code', $token)->first();

        if (!$user) {
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or unrecognized QR code.',
                ], 404);
            }

            return redirect()->route('login')->withErrors(['error' => 'Invalid or unrecognized QR code. Please try again.']);
        }

        Auth::login($user);
        if (request()->hasSession()) {
            request()->session()->regenerate();
        }

        $redirectUrl = ($user->type === 'admin')
            ? route('dashboard')
            : route('Pet.index');

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Logged in successfully via QR Code!',
                'redirect' => $redirectUrl,
                'user'     => [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                    'type'  => $user->type,
                ],
            ]);
        }

        return redirect()->intended($redirectUrl)
            ->with('success', "Welcome back, {$user->name}! You logged in via QR code.");
    }
}
