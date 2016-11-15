<?php

namespace SiegeLi;

// Laravel
use Illuminate\Support\ServiceProvider;

// Package
use SiegeLi\Console\MakeModelCommand;

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
                MakeModelCommand::class
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
