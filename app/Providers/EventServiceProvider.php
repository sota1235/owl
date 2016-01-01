<?php namespace Owl\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'event.name' => [
            'EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        $this->registerSubscriber();
    }

    /**
     * イベントハンドラーをSubscriberに登録
     */
    protected function registerSubscriber()
    {
        $dispatcher = $this->app->make('\Illuminate\Contracts\Events\Dispatcher');
        // メール送信イベントハンドラー
        $dispatcher->subscribe('\Owl\Handlers\Events\EmailNotification');
    }
}
