<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Libraries\Customlib;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailLeaveApproval;
use Illuminate\Http\Request;
use App\Http\Models\Admin\Employees;
use DateTime;
use DB;

class SendLeaveApprovalEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $timeout = 120;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->custom = new Customlib();
        $this->custom->mail_smtp();

        $enable_email = $this->custom->getSetting('ENABLE_EMAIL');
        if(isset($enable_email) && $enable_email == 'true')
        {
            $template = $this->custom->getTemplate(9);

            if(isset($template['status']) && $template['status'] == 1)
            {

                $employee = Employees::select('email')->where('status', 1)->where('id', $this->data['employee_id'])->first();
                if(isset($employee) && count($employee) > 0)
                {

                    $lDatess = DB::table('tbl_employees_leaves_dates')->whereLeaveId($this->data['leave_id'])->get();
                    $ld = [];
                    if(isset($lDatess) && count($lDatess) > 0){
                        foreach($lDatess as $ldates):
                            $ld[] = $ldates->leave_date;
                        endforeach;

                        $date1 = new DateTime(current($ld));
                        $date2 = new DateTime(end($ld));

                        $days = count($lDatess);
                        //$days = $date2->diff($date1)->format("%a");
                    }

                    $leave_start_date = date('Y-m-d', strtotime(current($ld)));
                    $leave_end_date = date('Y-m-d', strtotime(end($ld)));


                    $leave_start_date = $this->custom->dateformat($leave_start_date);
                    $leave_end_date = $this->custom->dateformat($leave_end_date);

                    $var = array('{employee_name}', '{leave_start_date}', '{leave_end_date}', '{leave_status}', '{business_name}');
                    $val = array($employee->first_name.' '.$employee->last_name, $leave_start_date, $leave_end_date, $this->data['leave_status'], $this->custom->getSetting('BUSINESS_NAME'));
                    $template_cotent = str_replace($var, $val, $template['content']); 
                    Mail::to($employee->email)->send(new EmailLeaveApproval($template_cotent));

                }
                
                
                
            }

        }


        
    }
}
