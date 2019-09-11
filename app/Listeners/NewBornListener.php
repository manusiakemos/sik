<?php

namespace App\Listeners;

use App\Events\NewBornEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewBornListener
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
     * @param  NewBornEvent  $event
     * @return void
     */
    public function handle(NewBornEvent $event)
    {
        //
    }
}
