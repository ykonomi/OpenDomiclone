<?php

namespace App\Listeners;

use App\Events\Result;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Result
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
     * @param  Result  $event
     * @return void
     */
    public function handle(Result $event)
    {
        //
    }
}
