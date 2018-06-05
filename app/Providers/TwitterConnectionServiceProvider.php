<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TwitterConnectionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'twitter_connection',
            'App\Libs\TwitterConnection'
        );
    }
}
