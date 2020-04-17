<?php 
namespace App\Libraries;

use App\Http\Models\Accounts\SalesLedger;
use App\Http\Models\Admin\EmailTemplates;
use App\Http\Models\Accounts\Purchase;
use App\Http\Models\Accounts\PurchaseLedger;
use Illuminate\Support\Facades\Mail;
use App\Http\Models\Admin\Settings;
use App\Http\Models\Accounts\Sales;
use Carbon\Carbon;
use Storage;
use Config;
use DB;

class Customlib{


	public function getInteger($string)
	{
		return preg_replace("/[^0-9]/", '', $string);
	}

	public function getInvoiceNumber()
	{
		$invoice_number = '00001';

		$sale = Sales::select('invoice_number', 'id')->orderBy('id', 'DESC')->first();
		if(!empty($sale))
		{
			$invoice_no = $this->getInteger($sale->invoice_number);
			$invoice_number = str_pad($invoice_no + 1, 5, 0, STR_PAD_LEFT);
            return $invoice_number;
		}

        elseif (empty($sale))
        {
            return $invoice_number;
        }
	}


	public function getVoucherNumber()
	{
		$invoice_number = '00001';
		$sale = Purchase::select('invoice_number', 'id')->orderBy('id', 'DESC')->first();
        if(!empty($sale))
		{
			$invoice_no = $this->getInteger($sale->invoice_number);
			$invoice_number = str_pad($invoice_no + 1, 5, 0, STR_PAD_LEFT);
		    return $invoice_number;
		}
        elseif (empty($sale))
        {
            return $invoice_number;
        }
	}


	public function getPaymentNumber()
	{
		$invoice_number = '00001';

		$sale = SalesLedger::select('payment_no', 'id')->orderBy('id', 'DESC')->first();
		if(!empty($sale))
		{
			$invoice_no = $this->getInteger($sale->payment_no);
			$invoice_number = str_pad($invoice_no + 1, 5, 0, STR_PAD_LEFT);
		}
        elseif (empty($sale))
        {
            return $invoice_number;
        }
	}


	public function getJournalCode()
	{
		$invoice_number = '00001';

		$journal = DB::table('tbl_accounts_summery')
		->select('code')
		->where('type', '1')
		->orderBy('code', 'DESC')
		->first();
		if(!empty($journal))
		{
			$invoice_no = $this->getInteger($journal->code);
			$invoice_number = str_pad($invoice_no + 1, 5, 0, STR_PAD_LEFT);
		}
        elseif (empty($journal))
        {
            return $invoice_number;
        }
	}

	public function getInterBankCode()
	{
		$invoice_number = '00001';

		$journal = DB::table('tbl_accounts_summery')
		->select('code')
		->where('type', '4')
		->orderBy('code', 'DESC')
		->first();
		if(!empty($journal))
		{
		
			$invoice_no = $this->getInteger($journal->code);
			$invoice_number = str_pad($invoice_no + 1, 5, 0, STR_PAD_LEFT);
		}
		elseif (empty($journal))
        {
            return $invoice_number;
        }
	}


	public function getSalaryCode()
	{
		$invoice_number = '00001';

		$sale = DB::table('tbl_accounts_summery')
		->select('code')
		->where('code', 'like', 'SE-%')
		->orderBy('code', 'DESC')
		->first();
		
			$invoice_no = $this->getInteger($sale->code);
			$invoice_number = str_pad($invoice_no + 1, 5, 0, STR_PAD_LEFT);
		

		return $invoice_number;
	}


	public function getVoucherPaymentNumber()
	{
		$invoice_number = '00001';
		
		$sale = PurchaseLedger::select('payment_no', 'id')->orderBy('id', 'DESC')->first();
		
		
		if(!empty($sale))
		{
			$invoice_no = $this->getInteger($sale->payment_number);
			$invoice_number = str_pad($invoice_no + 1, 5, 0, STR_PAD_LEFT);
		    return $invoice_number;
		}
        elseif (empty($sale))
        {
            return $invoice_number;
        }
		

		
	}


	public function getSetting($key)
	{

		$setting = Settings::where('config_name', $key)->first();
		return $setting->config_value;
	}


	public function getTemplate($id)
	{

		$tempArray = [];

		$template = EmailTemplates::whereId($id)->first();
		if($template->status == 1)
		{
			$content =  Storage::get('templates/'.$template->file_name);
			return $tempArray = array(
				'subject' => $template->subject,
				'file_name' => $template->file_name,
				'status' => $template->status,
				'content' => $content
			);
		}
	}


	public function mail_smtp(){

		
		if($this->getSetting('MAIL_BY') == 'gmail')
		{
			$config = array(
				'driver' => $this->getSetting('GMAIL_DRIVER'),
				'host' => $this->getSetting('GMAIL_HOST'),
				'port' => $this->getSetting('GMAIL_PORT'),
				'from' => array('address' => $this->getSetting('GMAIL_FROM_ADDRESS'), 'name' => $this->getSetting('GMAIL_FROM_NAME')),
				'encryption' => $this->getSetting('GMAIL_ENCRYPTION'),
				'username' => $this->getSetting('GMAIL_USERNAME'),
				'password' => $this->getSetting('GMAIL_PASSWORD'),
				'sendmail' => '\"C:\xampp\sendmail\sendmail.exe\" -t',
				'pretend' => false,
			);

		}elseif($this->getSetting('MAIL_BY') == "webmail"){

			$config = array(
				'driver' => $this->getSetting('MAIL_DRIVER'),
				'host' => $this->getSetting('MAIL_HOST'),
				'port' => $this->getSetting('MAIL_PORT'),
				'from' => array('address' => $this->getSetting('MAIL_FROM_ADDRESS'), 'name' => $this->getSetting('MAIL_FROM_NAME')),
				'encryption' => $this->getSetting('MAIL_ENCRYPTION'),
				'username' => $this->getSetting('MAIL_USERNAME'),
				'password' => $this->getSetting('MAIL_PASSWORD')
			);
		}
	
		Config::set('mail',$config);
	}


	public function mail($mailto = '', $cc = '', $bcc = '', $subject = '', $body = '', $attachment = '')
	{
		if($this->getSetting('MAIL_BY') == 'mail'){

		}else{

			$this->attachment_email($mailto, $cc, $bcc, $subject, $body, $attachment);
		}
	}

	
  public function attachment_email($mailto = '', $cc = '', $bcc = '', $subject = '', $body = '', $attachment = ''){

   		$this->mail_smtp();

   		$data = array(
   			'mailto'=> $mailto, 
   			'cc' => $cc,
   			'bcc' => $bcc,
   			'subject' => $subject,
   			'message' => $body,
   			'attachment' => $attachment,
   		);

		$mail = Mail::send([], [], function ($message) use ($data) {

			$message->to($data['mailto'])->subject($data['subject']);
			$message->setBody($data['message'], 'text/html');

			if(isset($data['cc']) && $data['cc'] <> "")
			{
				$message->cc($data['cc'], $data['subject']);
			}

			if(isset($data['bcc']) && $data['bcc'] <> "")
			{
				$message->bcc($data['bcc'], $data['subject']);
			}


			if(isset($data['attachment']) && $data['attachment'] <> "")
			{
				$message->attach($data['attachment']);
			}

		});

		if($mail)
		{
			return true;
		}

		return false;
   }



   	public function basic_email($mailto = '', $subject = '', $body = '', $cc = '')
	{

		$this->mail_smtp();
		$data = array('mailto'=> $mailto, 'subject' => $subject, 'message' => $body);

		Mail::send([], [], function ($message) use ($data) {
			
			 $message->to($data['mailto'])->subject($data['subject']);
			 $message->setBody($data['message'], 'text/html');
		});
   	}


	public function later_email($mailto = '', $subject = '', $body = '', $cc = '', $bcc = '')
	{
		$this->mail_smtp();
		$data = array('mailto'=> $mailto, 'subject' => $subject, 'message' => $body, 'cc' => $cc, 'bcc' => $bcc);

		Mail::queue([], $data, function ($message){
			
			 $message->to($data['mailto'])->subject($data['subject']);
			 //$message->setBody($data['message'], 'text/html');
		});
	}


   public function intCurrency($string = 0)
   {
		$string = str_replace(",", "", $string);
		return $string;
   }


   public function getCurrencyByCountryId($id = '')
   {
   		$cur = DB::table('tbl_countries')->whereId($id)->first();
   		if(isset($cur) )
   		{
   			return $cur->currency_code;
   		}

   		return false;
   }


   public function currenyFormat($value = '', $format = true)
	{
		
		$symbol = $this->getCurrencyByCountryId($this->getSetting('DEFAULT_CURRENCY'));
		$dec_point = $this->getSetting('DECIMAL_SEPRETOR');
		$thousands_sep = $this->getSetting('THOUSAND_SEPRETOR');
	
		$string = number_format($value, 2, $dec_point, $thousands_sep);

		if($symbol)
		{
			$string .= ' '.$symbol;
		}

		return $string;
	}


	public function currencyFormatSymbol()
	{
		$symbol = $this->getCurrencyByCountryId($this->getSetting('DEFAULT_CURRENCY'));
		return $symbol;
	}



    public function getShiftByEmployee($employee_id = '')
    {
        $shift = DB::table('tbl_shift')
        ->select('start_time', 'end_time', 'title')
        ->leftJoin('tbl_employees', 'tbl_employees.shift_id', '=', 'tbl_shift.id')
        ->where('tbl_employees.id', $employee_id)
        ->first();

        if(isset($shift) )
        {
        	return $shift;
        }

        return false;
    }



    function getSecToTime($seconds) {

      $hours = floor($seconds / 3600);
      $minutes = floor(($seconds / 60) % 60);
      $seconds = $seconds % 60;

      $hours = ($hours > 0) ? $hours * 60 : 0;
      $minutes = ($minutes > 0) ? $minutes: 0;

      //$total_mintues =  $hours + $minutes;
      if($hours > 0 || $minutes > 0)
      {
        return $hours;
      }

      return '0';

    }


    function dateformat($date = '')
    {

    	if($date <> ""){
    		$d = Carbon::parse($date);
    		return $d->format('d M, Y');
    	}

    	return '';
    }



    function timeformat($datetime = '')
    {
    	if(!empty($datetime))
    	{
    		$t = Carbon::parse($datetime);
    		return $t->format('h:i:s A');
    	}

    	return '';
    }


    function pervous_month_date(){
    	$current_date = date('Y-m-d', time());
    	return date('m/d/Y', strtotime("-1 MONTH", $current_date));
    }


    function sqldateformat($date = '')
    {
    	if($date <> ""){
    		$d = Carbon::parse($date);
    		return $d->format('Y-m-d');
    	}
    	return '';
    }

}