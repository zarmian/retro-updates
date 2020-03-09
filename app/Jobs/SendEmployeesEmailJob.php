<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Libraries\Customlib;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailEmployee;
use Illuminate\Http\Request;
use App\Http\Models\Admin\Employees;

class SendEmployeesEmailJob implements ShouldQueue
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
            $template = $this->custom->getTemplate(1);

            if(isset($template['status']) && $template['status'] == 1)
            {
                $employee = Employees::find($this->data['employee_id']);
                $var = array('{first_name}', '{last_name}', '{username}', '{password}', '{email}', '{business_name}');
                $val = array($employee->first_name, $employee->last_name, $employee->username, $this->data['password'], $employee->email, $this->custom->getSetting('BUSINESS_NAME'));
                
                $template_cotent = str_replace($var, $val, $template['content']);
                Mail::to($this->data['email'])->send(new EmailEmployee($template_cotent));
                
            }

        }


        
    }
}