<?php

namespace SylveK\LaravelPasswordPolicies;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

use SylveK\LaravelPasswordPolicies\Commands\ClearPasswordHistory;

// use SylveK\LaravelPasswordPolicies\Observers\UserObserver;

class LaravelPasswordPoliciesServiceProvider extends ServiceProvider
{
    // -- Bootstrap the application services.
    public function boot(Filesystem $filesystem)
    {
        if ($this->app->runningInConsole()) {
            if (function_exists('config_path')) { // function not available and 'publish' not relevant in Lumen

                $this->publishes([
                    __DIR__.'/../config/password-policies.php' => config_path('password-policies.php'),
                ], 'config');

                $this->publishes([
                    __DIR__.'/../database/migrations/create_password_histories_table.php.stub' => $this->getMigrationFileName($filesystem),
                ], 'migrations');
            }

            // -- Registering package commands.
            $this->commands([
                ClearPasswordHistory::class
            ]);
        }

        // collect(config('password-policies.password_history_models')) -> map(function ($model) {
        //     class_exists($model['class']) ? $model['class']::observe(UserObserver::class) : null;
        // });
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     *
     * @param Filesystem $filesystem
     * @return string
     */
    protected function getMigrationFileName(Filesystem $filesystem): string
    {
        $timestamp = date('Y_m_d_His');

        return Collection::make($this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem) {
                return $filesystem->glob($path.'*_create_password_histories_table.php');
            })->push($this->app->databasePath()."/migrations/{$timestamp}_create_password_histories_table.php")
            ->first();
    }

    // -- Register the application services.
    public function register()
    {
        // -- Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/password-policies.php', 'password-policies');
    }
}
