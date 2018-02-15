<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\OtherEntry' => [
            'App\Listeners\OtherEntryListener',
        ],
        'App\Events\Attack' => [
            'App\Listeners\AttackListener',
        ],
        'App\Events\TurnChange' => [
            'App\Listeners\TurnChangeListener',
        ],
        'App\Events\GameOver' => [
            'App\Listeners\GameOverListener',
        ],
        'App\Events\CountedVictory' => [
            'App\Listeners\CountedVictoryListener',
        ],
        'App\Events\SettingCompleted' => [
            'App\Listeners\SettingCompletedListener',
        ],
        'App\Events\Result' => [
            'App\Listeners\ResultListener',
        ],
        'App\Events\TurnChanged' => [
            'App\Listeners\TurnChangedListener',
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
