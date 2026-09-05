<?php

namespace App\Notifications;

use App\Traits\HandelQrCode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendQr extends Notification implements ShouldQueue
{
    use Queueable, HandelQrCode;




    /**
     * Create a new notification instance.
     */
    // امسح $qrPath من الـ constructor خالص
    public function __construct() {}


    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $loginUrl = route('qr.login', ['token' => $notifiable->qr_code]);
        $qrBase64 = $this->generateQrCode($loginUrl);

        return (new MailMessage)
            ->subject('Your Login QR Code')
            ->view('emails.qr-code', [
                'user' => $notifiable,
                'qrBase64' => $qrBase64,
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
