<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Libraries\Customlib;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailLoanApproval;
use Illuminate\Http\Request;
use App\Http\Models\Admin\Employees;

class SendLoanApprovalEmailJob implements ShouldQueue
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
            $template = $this->custom->getTemplate(17);

            if(isset($template['status']) && $template['status'] == 1)
            {
                $var = array('{employee_name}', '{loan_amount}', '{loan_reason}', '{loan_status}', '{approval_date}', '{business_name}');
                $val = array($this->data['employee_name'], $this->data['loan_amount'], $this->data['loan_reason'], $this->data['loan_status'], $this->data['approval_date'], $this->custom->getSetting('BUSINESS_NAME'));
                $template_cotent = str_replace($var, $val, $template['content']); 
                
                $employee = Employees::select('email')->where('status', 1)->where('id', $this->data['employee_id'])->first();
                if(isset($employee) && count($employee) > 0)
                {
                    Mail::to($employee->email)->send(new EmailLoanApproval($template_cotent));
                }
                
            }

        }


        
    }
}
