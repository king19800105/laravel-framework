<?php

namespace App\Providers;

use App\Events\{
    AdminLoginEvent
};
use App\Listeners\{SendSMSNotice, UpdateLoginStatus};
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AdminLoginEvent::class => [
            SendSMSNotice::class,
            UpdateLoginStatus::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
