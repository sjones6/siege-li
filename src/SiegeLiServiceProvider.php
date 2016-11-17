<?php

namespace SiegeLi;

// Laravel
use Illuminate\Support\ServiceProvider;

// Package
use SiegeLi\Console\MakeModelCommand;
use SiegeLi\Console\MakeControllerCommand;
use SiegeLi\Console\MakeViewsCommand;
use SiegeLi\Console\MvcCommand;
use SiegeLi\Console\GroupCommand;

class SiegeLiServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the package services.
     *
     * @return void
     */
    public function boot()
    {

        // Load Console commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeModelCommand::class,
                MakeControllerCommand::class,
                MvcCommand::class,
                MakeViewsCommand::class,
                GroupCommand::class,
            ]);
        }

        // Publish stubs, config
        $this->publishes([
            __DIR__.'/Stubs' => resource_path('stubs/base/'),
            __DIR__.'/config.php' => config_path('stubs.php')
        ], 'public');

    }

    /**
     * Register the package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
