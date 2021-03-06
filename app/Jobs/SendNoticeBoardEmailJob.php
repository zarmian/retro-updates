<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Libraries\Customlib;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNoticeBoard;
use Illuminate\Http\Request;
use App\Http\Models\Admin\Employees;

class SendNoticeBoardEmailJob implements ShouldQueue
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
            $template = $this->custom->getTemplate(11);

            if(isset($template['status']) && $template['status'] == 1)
            {
                $var = array('{title}', '{date}', '{description}', '{business_name}');
                $val = array($this->data['title'], $this->data['date'], $this->data['description'], $this->custom->getSetting('BUSINESS_NAME'));
                $template_cotent = str_replace($var, $val, $template['content']); 
                
                $employees = Employees::select('email')->where('status', 1)->get();
                if(isset($employees) && count($employees) > 0)
                {
                    foreach($employees as $employee)
                    {
                        Mail::to($employee->email)->send(new EmailNoticeBoard($template_cotent));
                    }
                }
                
            }

        }


        
    }
}
