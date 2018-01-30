<?php

namespace App\Listeners;

use App\Events\SettingCompleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SettingCompleted
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
     * @param  SettingCompleted  $event
     * @return void
     */
    public function handle(SettingCompleted $event)
    {
        //
    }
}
