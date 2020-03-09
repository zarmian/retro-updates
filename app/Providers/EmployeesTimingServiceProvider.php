<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Http\Models\Employees\EmployeesAttendance;
use Auth;
use DB;
use Carbon;

class EmployeesTimingServiceProvider extends ServiceProvider
{

    protected $guard = 'auth';
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
        view()->composer('layouts.header', function ($view) {

            $time = Carbon\Carbon::now();
            $date = $time->toDateString();

            $user_id = Auth::guard($this->guard)->user()->id;

            $row = EmployeesAttendance::whereEmployeeId($user_id)->whereDate('in_time', '=', $date)->orderBy('id', 'desc')->first();


            if(isset($row) && count($row) > 0){
                
                if(empty($row->out_time) && is_null($row->out_time) && $row->out_time == ""){

                    $data['link'] = '<button class="btn btn-xs time-out timing-action btn-block" id="timing-action" data-status="1">Time Out &nbsp;&nbsp; <i class="fa fa-clock-o"></i></button>';
                }else{

                    $data['link'] = '<button class="btn btn-xs time-in timing-action btn-block" id="timing-action" data-status="0">Time In &nbsp;&nbsp; <i class="fa fa-clock-o"></i></button>';
                }
                
            }else{
                $data['link'] = '<button class="btn btn-block btn-xs time-in timing-action btn-block" id="timing-action" data-status="0">Time In &nbsp;&nbsp; <i class="fa fa-clock-o"></i></button>';
            }

          

            $view->data = $data;
        });
    }

}