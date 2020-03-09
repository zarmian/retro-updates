<?php

namespace App\Providers;
use App\Libraries\Customlib;
use Config;
use Schema;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function __construct(){
        $this->custom = new Customlib();
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (class_exists('Customlib')) {
            $time_zone = $this->custom->getsetting('TIMEZONES');
            @date_default_timezone_set($time_zone);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       
    }
}
