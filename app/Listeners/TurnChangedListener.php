<?php

namespace App\Listeners;

use App\Events\TurnChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TurnChangedListener
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
     * @param  TurnChanged  $event
     * @return void
     */
    public function handle(TurnChanged $event)
    {
        //
    }
}
