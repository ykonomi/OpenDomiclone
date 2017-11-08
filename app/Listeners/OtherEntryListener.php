<?php

namespace App\Listeners;

use App\Events\OtherEntry;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OtherEntryListener
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
     * @param  OtherEntry  $event
     * @return void
     */
    public function handle(OtherEntry $event)
    {
        //
    }
}
