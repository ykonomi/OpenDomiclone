<?php

namespace App\Listeners;

use App\Events\Attack;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AttackListener
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
     * @param  Attack  $event
     * @return void
     */
    public function handle(Attack $event)
    {
        //
    }
}
