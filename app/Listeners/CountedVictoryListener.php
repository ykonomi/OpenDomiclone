<?php

namespace App\Listeners;

use App\Events\CountedVictory;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CountedVictoryListener
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
     * @param  CountedVictory  $event
     * @return void
     */
    public function handle(CountedVictory $event)
    {
        //
    }
}
