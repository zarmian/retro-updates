<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libraries\Customlib;
use Storage;
use Auth;
use DB;

class AdminNoticeBoardProvider extends ServiceProvider
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->custom = new Customlib();
    }


    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.header', function ($view) {

            $data['notices'] = [];

            $default = Auth::guard('auth')->user()->roles->default;
            if($default == 1)
            {
                $notices = DB::table('tbl_noticeboard')->whereUnread(1)->whereType(2)->get();
            
                if(isset($notices) && count($notices) > 0){

                    foreach($notices as $notice){

                        $data['notices'][] = [
                            'url' => url('admin/notification/show', $notice->id),
                            'title' => $notice->title,
                            'date' => date('d, M Y', strtotime($notice->datetime)),
                            'description' => $notice->description,
                        ];
                    }
                }


                $leaves = DB::table('tbl_employees_leaves')->whereUnread(1)->get();
                if(isset($leaves) && count($leaves) > 0){

                    foreach($leaves as $leave){

                        $lDates = DB::table('tbl_employees_leaves_dates')->whereLeaveId($leave->id)->get();
                        $ld = [];
                        if(isset($lDates) && count($lDates) > 0){
                            foreach($lDates as $ldate):
                                $ld[] = $ldate->leave_date;
                            endforeach;
                        }

                        $data['notices'][] = [
                            'url' => url('/leave/show', $leave->id),
                            'title' => $leave->title,
                            'date' => date('d, M Y', strtotime(current($ld))) .' TO '. date('d, M Y', strtotime(end($ld))),
                            'description' => $leave->description,
                        ];
                    }

                }


                $loans = DB::table('tbl_employees_loans')->whereUnread(1)->get();
                if(isset($loans) && count($loans) > 0){

                    foreach($loans as $loan){

                        $data['notices'][] = [
                            'url' => url('/employees/loans/show', $loan->id),
                            'title' => $loan->title,
                            'date' => date('d, M Y', strtotime($loan->datetime)),
                            'description' => $loan->detail,
                        ];
                    }

                }
            }else{

                $notices = DB::table('tbl_noticeboard')->whereUnread(1)->whereType(1)->get();
            
                if(isset($notices) && count($notices) > 0){

                    foreach($notices as $notice){

                        $data['notices'][] = [
                            'url' => url('/notification/show', $notice->id),
                            'title' => $notice->title,
                            'date' => date('d, M Y', strtotime($notice->datetime)),
                            'description' => $notice->description,
                        ];
                    }
                }
            
            }

         
            $view->notices = $data['notices'];

        });
    }

}
