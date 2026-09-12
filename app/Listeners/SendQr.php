<?php

namespace App\Listeners;

use App\Events\GenrateQr;
use App\Traits\HandelQrCode;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendQr
{
    use HandelQrCode;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(GenrateQr $event): void
    {
        $this->sendQr($event->user);
    }
}