<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SwapiService;
use GuzzleHttp\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SwapiService::class, function ($app) {
            return new SwapiService(new Client());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
