<?php

namespace App\Listeners;

use App\Events\DevelopmentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\SendDevelopmentNotification;

class NotifyDevelopmentCreated
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
    public function handle(DevelopmentCreated $event): void
    {
        SendDevelopmentNotification::dispatch($event->development);
    }
}
