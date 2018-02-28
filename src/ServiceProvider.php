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

        \Event::listen(\Illuminate\Routing\Events\RouteMatched::class, function ($event) {

            if (\Cache::has('old_extended_date')) {

                $request = $this->app->make('request');
                $old_extended_date = \Cache::get('old_extended_date');
                foreach ($old_extended_date as $key => $mutation) {

                    if ($request->offsetExists($key)){

                        $value = $request->offsetGet($key);
                        $mutate = explode(':::', $mutation);
                        $value = old_date($key, $value, $mutate[0], $mutate[1]);

                        $request->offsetSet($key, $value);
                    }
                }

                \Cache::forget('old_extended_date');
            }
        });
    }
}
