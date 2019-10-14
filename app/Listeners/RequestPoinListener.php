<?php

namespace App\Listeners;

use App\Events\RequestPoinEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestPoinListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(RequestPoinEvent $event)
    {
        sendMessage("Ada permintaan tukar poin bidan", "data-poin", "Tukar Poin", "", "https://sik.tabalongkab.go.id/#/home:");
    }
}
