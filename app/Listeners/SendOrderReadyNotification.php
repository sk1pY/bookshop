<?php

namespace App\Listeners;

use App\Events\OrderReady;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendOrderReadyNotification implements ShouldQueue
{
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
    public function handle(OrderReady $event): void
    {
        $user = $event->order->user;
        $user->notify(new \App\Notifications\OrderReadyNotification($event->order));

    }
}
