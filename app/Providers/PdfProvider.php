<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PdfProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        echo __DIR__;
        $this->app->singleton('', function ($app) {
            return new Connection(config('riak'));
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('mpdf.pdf');
    }
}
