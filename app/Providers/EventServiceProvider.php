<?php

namespace App\Providers;

use App\Events\DispensaryHasBeenInvolvedInRecall;
use App\Events\ProductHasBeenInvolvedInRecall;
use App\Listeners\LogActivityListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Overtrue\LaravelFavorite\Events\Favorited;
use Overtrue\LaravelFavorite\Events\Unfavorited;
use Overtrue\LaravelFollow\Events\Followed;
use Overtrue\LaravelFollow\Events\Unfollowed;
use Overtrue\LaravelLike\Events\Liked;
use Overtrue\LaravelLike\Events\Unliked;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Liked::class => [],
        Unliked::class => [],
        Followed::class => [],
        Unfollowed::class => [],
        Favorited::class => [],
        Unfavorited::class => [],
        
        DispensaryHasBeenInvolvedInRecall::class => [
            LogActivityListener::class,
        ],
        ProductHasBeenInvolvedInRecall::class => [
            LogActivityListener::class,
        ],
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

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
