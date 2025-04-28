<?php

namespace App\Services\ParseService;

use Illuminate\Support\ServiceProvider;

class ParseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('parse_service', function () {
            return new ParseService();
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
