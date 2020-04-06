<?php

namespace SylveK\LaravelPasswordPolicies;

use Illuminate\Support\ServiceProvider;

// use SylveK\LaravelPasswordPolicies\Observers\UserObserver;

class LaravelPasswordPoliciesServiceProvider extends ServiceProvider
{
    // -- Bootstrap the application services.
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/password-policies.php' => config_path('password-policies.php'),
            ], 'password-policies');

            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

            // -- Registering package commands.
            $this->commands([
                ClearPasswordHistory::class
            ]);
        }

        // collect(config('password-policies.password_history_models')) -> map(function ($model) {
        //     class_exists($model['class']) ? $model['class']::observe(UserObserver::class) : null;
        // });
    }

    // -- Register the application services.
    public function register()
    {
        // -- Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/password-policies.php', 'password-policies');
    }
}
