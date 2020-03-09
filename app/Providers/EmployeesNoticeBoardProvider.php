<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use DB;

class EmployeesNoticeBoardProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.employees.header', function ($view) {

            $data['notices'] = [];

            $notices = DB::table('tbl_noticeboard')->whereUnread(1)->whereType(1)->get();
            
            if(isset($notices) && count($notices) > 0){

                foreach($notices as $notice){

                    $data['notices'][] = [
                        'url' => url('employees/notification/show', $notice->id),
                        'title' => $notice->title,
                        'date' => date('d, M Y', strtotime($notice->datetime)),
                        'description' => $notice->description,
                    ];
                }
            }

            $view->notices = $data['notices'];

        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
