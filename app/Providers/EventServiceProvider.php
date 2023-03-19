<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\UpdateStatusToPAid;
use App\Listeners\SendAutoEmail;
use App\Events\HistoryForSentEmails;
use App\Listeners\LogSentEmail;
use Illuminate\Mail\Events\MessageSent;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UpdateStatusToPAid::class => [
            SendAutoEmail::class,
        ]
        // HistoryForSentEmails::class => [
        //     LogSentEmail::class,
        // ] ,
        // MessageSent::class => [
        //     LogSentEmail::class,
        // ]
    ];


    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [

        'App\Listeners\LogSentEmail'

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
