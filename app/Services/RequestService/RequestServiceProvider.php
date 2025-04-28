<?php

namespace App\Services\RequestService;

use Illuminate\Support\ServiceProvider;

class RequestServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('request_service', function () {
            return new RequestService();
        });
    }
}
