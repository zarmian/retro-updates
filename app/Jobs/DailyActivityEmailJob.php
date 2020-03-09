<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailDailyActivity;
use App\Libraries\Customlib;


class DailyActivityEmailJob implements ShouldQueue
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
            $template = $this->custom->getTemplate(15);

            if(isset($template['status']) && $template['status'] == 1)
            {

                $admin_email = $this->custom->getSetting('BUSINESS_EMAIL');

                $var = array('{new_customers}', '{new_vendors}', '{new_invoice}', '{new_voucher}', '{new_received_amount}', '{new_paid_amount}', '{today_expenses}', '{bank_cash_debit}', '{bank_cash_credit}', '{total_employees}', '{today_total_present_employees}', '{today_total_absent_employees}', '{today_total_short_attendance}', '{business_name}');

                $val = array($this->data['customers'], $this->data['vendors'], $this->data['invoice'], $this->data['purchase'], $this->data['recieved'], $this->data['paid'], $this->data['journal_expense_debit'], $this->data['bank_cash_debit'], $this->data['bank_cash_credit'], $this->data['total_employees'], $this->data['today_total_present_employees'], $this->data['today_total_absent_employees'], $this->data['today_total_short_attendance'], $this->custom->getSetting('BUSINESS_NAME'));

                $template_cotent = str_replace($var, $val, $template['content']); 
                
                Mail::to($admin_email)->send(new EmailDailyActivity($template_cotent, $this->data));
                
                
            }

        }
    }
}
