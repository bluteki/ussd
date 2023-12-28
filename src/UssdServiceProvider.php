<?php

namespace Bluteki\Ussd;

use Illuminate\Support\ServiceProvider;

class UssdServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Automatically load migrations.
        $this->loadMigrationsFrom(dirname(__DIR__) . '/database/migrations');

        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([ __DIR__ . '/../config/config.php' => config_path('ussd.php')], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'ussd');

        // Register the main class to use with the facade
        $this->app->singleton('ussd', fn () => new Ussd);
    }
}
