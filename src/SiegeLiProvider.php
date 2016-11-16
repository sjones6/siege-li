<?php

namespace SiegeLi;

// Laravel
use Illuminate\Support\ServiceProvider;

// Package
use SiegeLi\Console\MakeModelCommand;
use SiegeLi\Console\MakeControllerCommand;

class SiegeLiProvider extends ServiceProvider
{

    /**
     * Bootstrap the package services.
     *
     * @return void
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeModelCommand::class,
                MakeControllerCommand::class
            ]);
        }

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
