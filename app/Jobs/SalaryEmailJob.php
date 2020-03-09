<?php

namespace App\Jobs;

use App\Libraries\Customlib;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Models\Admin\Employees;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailSalary;

class SalaryEmailJob implements ShouldQueue
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
            $template = $this->custom->getTemplate(12);

            if(isset($template['status']) && $template['status'] == 1)
            {
                
                if(isset($this->data) && count($this->data) > 0){
                    foreach($this->data as $row)
                    {

                        $employee = Employees::select('email', 'first_name', 'last_name')->where('id', $row['employee_id'])->first();
                        
                        $var = array('{employee_name}', '{salary_date}', '{salary_amount}', '{business_name}');
                        $val = array($employee->first_name.' '.$employee->last_name, $row['salary_date'], $row['generated_pay'], $this->custom->getSetting('BUSINESS_NAME'));
                        $template_cotent = str_replace($var, $val, $template['content']);
                        Mail::to($employee->email)->send(new EmailSalary($template_cotent, $this->data));
                       
                        
                    }
                }
                
            }

        }
    }
}
