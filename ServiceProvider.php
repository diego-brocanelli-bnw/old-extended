<?php

namespace LaravelFormHelpers;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        include('helpers.php');
    }
}
