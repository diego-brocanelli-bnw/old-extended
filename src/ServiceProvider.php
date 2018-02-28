<?php

namespace OldExtended;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Em modo de desenvolvimento, as views são sempre apagadas
        if (env('APP_DEBUG') || env('APP_ENV') === 'local') {
        	
        	$this->loadViewsFrom(__DIR__.'/resources/views', 'old-extended');
            $this->loadRoutesFrom(__DIR__.'/routes.php');
        }

        \OldExtended::loadHelpers();

        /*
        \Event::listen('*', function ($event) {
            echo $event . '<br>';
        });
        */

        /*
        //\Event::listen(Illuminate\Routing\Events\RouteMatched::class, function ($event) {
            // ...            
        });
        */
    }
}
