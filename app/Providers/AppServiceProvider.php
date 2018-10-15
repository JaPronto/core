<?php

namespace App\Providers;

use App\Observers\UserObserver;
use App\Services\Api;
use App\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $observers = [
        User::class => [
            UserObserver::class
        ],
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $this->bootObservers();
    }

    /**
     * Setup all model observers
     */
    public function bootObservers()
    {
        foreach ($this->observers as $class => $observer) {
            $this->bootObserver($class, $observer);
        }
    }

    public function bootObserver($class, $observer)
    {
        if (is_array($observer)) {
            foreach ($observer as $obs) {
                $this->bootObserver($class, $obs);
            }

            return;
        }

        resolve($class)->observe($observer);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('api', Api::class);
        $this->app->singleton('OAUTH_PASSWORD_CLIENT', function() {
            return DB::table('oauth_clients')->where('name', 'Laravel Password Grant Client')->first(['id', 'secret']);
        });
    }
}
