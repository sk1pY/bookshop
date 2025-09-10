<?php

namespace App\Listeners;

use App\Events\OrderCancelled;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderCancelledNotification implements ShouldQueue
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
    public function handle(OrderCancelled $event): void
    {
        $user = $event->order->user;
        $user->notify(new \App\Notifications\OrderCancelledNotification($event->order));
    }
}
