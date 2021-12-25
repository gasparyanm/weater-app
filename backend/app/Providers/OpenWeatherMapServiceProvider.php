<?php

namespace App\Providers;

use App\Services\OpenWeatherMapService;
use Illuminate\Support\ServiceProvider;

/**
 * Class OpenWeatherMapServiceProvider
 * @package App\Providers
 */
class OpenWeatherMapServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(OpenWeatherMapService::class, function ($app) {
            return new OpenWeatherMapService(
                $app->config['openweathermap']['apiUrl'],
                $app->config['openweathermap']['apiKey'],
            );
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
