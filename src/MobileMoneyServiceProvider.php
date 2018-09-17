<?php

namespace Edgetech\MobileMoney;

use Illuminate\Support\ServiceProvider;

class MobileMoneyServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'edgetech');
         $this->loadViewsFrom(__DIR__.'/Mpesa/resources/views', 'edgetech');
         $this->loadMigrationsFrom(__DIR__.'/Mpesa/database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {

            // Publishing the configuration file.
            $this->publishes([
                __DIR__.'/../config/mobilemoney.php' => config_path('mobilemoney.php'),
            ], 'mobilemoney.config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/edgetech'),
            ], 'mobilemoney.views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/edgetech'),
            ], 'mobilemoney.views');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/edgetech'),
            ], 'mobilemoney.views');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/mobilemoney.php', 'mobilemoney');

        // Register the service the package provides.
        $this->app->singleton('mobilemoney', function ($app) {
            return new MobileMoney;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['mobilemoney'];
    }
}