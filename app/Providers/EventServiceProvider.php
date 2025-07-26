<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\AnswerCreated;
use App\Listeners\SendAnswerNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        AnswerCreated::class => [
            SendAnswerNotification::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
