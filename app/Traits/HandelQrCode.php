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
     * Login user via QR token.
     */
    public function login(string $token)
    {
        $user = User::where('qr_code', $token)->firstOrFail();

        Auth::login($user);
        request()->session()->regenerate();
        if ($user->type === 'admin') {
            return redirect()->route('AdminDashboard');
        }

        return redirect()->route('UserDashboard');
    }
}
