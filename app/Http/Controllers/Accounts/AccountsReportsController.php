<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Accounts\AccountsSummeryDetail;
use App\Http\Models\Accounts\AccountsSummery;
use App\Http\Models\Accounts\AccountsChart;
use App\Http\Models\Accounts\AccountsType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Customlib;
use Carbon\Carbon;
use Excel;
use DB;

class AccountsReportsController extends Controller
{

    public $pervous_month = '';
    public function __construct()
    {
        $this->custom = new Customlib();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	try {

    		$data = [];
    		$data['accounts'] = [];

            $accounts = AccountsType::all();
           
            if(isset($accounts) )
            {
                foreach($accounts as $account)
                {

                   $coa = [];
                    if(isset($account->children) )
                    {
                        foreach($account->children as $child)
                        {
                            
                            if(isset($child->chartofacc) ){

                                foreach($child->chartofacc as $ac){
                                    $coa[] = [
                                        'id' => $ac->id,
                                        'cid' => $ac->cid,
                                        'name' => $ac->name,
                                        'code' => $ac->code,
                                        'type_id' => $ac->type_id,
                                        'opening' => $ac->opening_balance,
                                        'balance_type' => $ac->balance_type,
                                        'is_systemize' => $ac->is_systemize,
                                        'type_name' => $ac->type->name,
                                    ];
                                }
                            }
                            
                            
                        }
                    }

                    $coa = array_values(array_sort($coa, function ($value) {
                        return $value['code'];
                    }));
                    

                    $data['accounts'][] = [
                        'id' => $account->id,
                        'name' => $account->name,
                        'coa' => $coa
                    ];
                }
            }

            return view('accounting.reports.statement', $data);
    		
    	} catch (ModelNotFoundException $e) {
    		
    	}
    }


    public function getAccountStatmentReport(Request $request)
    {
    	try {


    		$this->validate($request, [
    			'account' => 'required'
    		]);
    		
    		$data['results'] = [];
    		$data['opening'] = [];
    		$op_cr = 0;
    		$op_dr = 0;

    		$to = $request->input('to');
    		$from = $request->input('from');

    		$nice_to_date = Carbon::createFromFormat('m/d/Y', $to)->toDateString();
    		$nice_from_date = Carbon::createFromFormat('m/d/Y', $from)->toDateString();
    		$data['account_id'] = $request->input('account');

    		$data['to'] = $this->custom->dateformat($nice_to_date);
    		$data['from'] = $this->custom->dateformat($nice_from_date);

    		$query = AccountsSummeryDetail::query();

			$query->where('tbl_accounts_summery_detail.account_id', $data['account_id']);
			$query->where('tbl_accounts_summery_detail.date', '>=', $nice_to_date);
            $query->where('tbl_accounts_summery_detail.date', '<=', $nice_from_date);
            $query->leftJoin('tbl_accounts_summery', 'tbl_accounts_summery.id', '=', 'tbl_accounts_summery_detail.summery_id');
            //$query->orderBy('id', 'DESC');
    		$rows = $query->get();

            $data['opening_cr'] = '0.00';
            $data['opening_dr'] = '0.00;';

    		$opening = AccountsChart::where('id', $data['account_id'])->first();
    		if(isset($opening) )
    		{

                if(isset($opening) && $opening == "cr"){
                    $data['opening_cr'] = number_format($opening['opening_balance'], 2);
                }else{
                    $data['opening_dr'] = number_format($opening['opening_balance'], 2);
                }
    			
    		}

    		if(isset($rows) )
    		{
                
                $tlt_dr=0; $tlt_cr=0;$tlt_balance=0;
                $prevBalance = $opening['opening_balance'];
                $code_caption = '';
                $text_caption = '';
    			foreach($rows as $row)
    			{

                    if($row->type == 1){
                        $code_caption = __('admin/entries.journal_entry_short_txt');
                        $text_caption = __('admin/entries.journal_entry_txt');
                    }elseif($row->type==2){
                        $code_caption = __('admin/entries.payment_entry_short_txt');
                        $text_caption = __('admin/entries.sales_and_purchase_txt');
                    }elseif($row->type==3){
                        $code_caption = __('admin/entries.salary_short_code_txt');
                        $text_caption = __('admin/entries.salary_txt');
                    }elseif($row->type==4){
                       $code_caption = __('admin/entries.ib_txt');
                       $text_caption = __('admin/entries.bank_transfer_txt');
                    }
                    

                 
                    if(isset($opening) && $opening == "cr")
                    {
                        $balance = ($prevBalance - $row['debit']) + $row['debit'];
                    }else{
                        $balance = ($prevBalance + $row['credit']) - $row['debit'];
                    }

                    if(isset($row['debit']) && $row['debit'] > 0){
                        $payment_detail = __('admin/entries.amt_paid_to_txt').' '.$this->getStatmentDebit($row['summery_id']);
                    }else{
                        $payment_detail = __('admin/entries.amt_paid_from_txt').' '.$this->getStatmentCredit($row['summery_id']);
                    }

                    $description = $row['description'];
                    
                    if(!isset($row['description']) && $row['description'] == '')
                    {
                        $description = $text_caption;
                    }
                    
    				$data['results'][] = [
    					'account_id' => $row['account_id'],
    					'code' => $code_caption.'-'.$row['code'], 
                        'cc' => $code_caption,
    					'account_name' => $row->account->name,
    					'date' => $this->custom->dateformat($row['date']),
    					'description' => $description,
    					'debit' => number_format($row['debit'], 2),
    					'credit' => number_format($row['credit'], 2),
    					'balance' => number_format($balance, 2),
                        'payment_detail' => $payment_detail,
                        'text_caption' => $text_caption
    				];

                    $tlt_dr = $tlt_dr + $row['debit'];
                    $tlt_cr = $tlt_cr + $row['credit'];
                    $tlt_balance =  $balance;

                    $prevBalance = $balance;
    			}

                $data['tlt_dr'] = number_format($tlt_dr, 2);
                $data['tlt_cr'] = number_format($tlt_cr, 2);
                $data['tlt_balance'] = number_format($tlt_balance, 2);
    		}

           
    		$accounts = AccountsType::whereParent('0')->get();
            if(isset($accounts) )
            {
                foreach($accounts as $account)
                {

                   $coa = [];
                    if(isset($account->children) )
                    {
                        foreach($account->children as $child)
                        {
                            
                            if(isset($child->chartofacc) ){

                                foreach($child->chartofacc as $ac){
                                    $coa[] = [
                                        'id' => $ac->id,
                                        'cid' => $ac->cid,
                                        'name' => $ac->name,
                                        'code' => $ac->code,
                                        'type_id' => $ac->type_id,
                                        'opening' => $ac->opening_balance,
                                        'balance_type' => $ac->balance_type,
                                        'is_systemize' => $ac->is_systemize,
                                        'type_name' => $ac->type->name,
                                    ];
                                }
                            }
                        }
                    }

                    $coa = array_values(array_sort($coa, function ($value) {
                        return $value['code'];
                    }));
                    

                    $data['accounts'][] = [
                        'id' => $account->id,
                        'name' => $account->name,
                        'coa' => $coa
                    ];
                }
            }

            $data['currency'] = $this->custom->currencyFormatSymbol();

    		return view('accounting.reports.statement', $data);
    		
    		

    	} catch (ModelNotFoundException $e) {
    		
    	}
    }


    protected function getStatmentDebit($summery_id = '')
    {

        $row = AccountsSummeryDetail::select('account_id')->where('summery_id', $summery_id)->orderBy('id', 'ASC')->first();
        $account_name = $row->account->name;
        //$account = AccountsChart::select('name')->where()
        return $account_name;
    }


    protected function getStatmentCredit($summery_id = '')
    {
        $row = AccountsSummeryDetail::select('account_id')->where('summery_id', $summery_id)->orderBy('id', 'DESC')->first();

        $account_name = $row->account->name;
        return $account_name;
    }


    public function bankCash()
    {
        try {

            $data['banks'] = [];
            $type_id = 37;
            $banks = AccountsChart::select('id','code', 'name', 'opening_balance', 'balance_type')->whereTypeId($type_id)
            ->orWhere('type_id',38)
            ->get();
            
            $data['tlt_balance_amt'] = 0;
            if(isset($banks) )
            {
                $tlt_debit = 0; $tlt_credit = 0; $tlt_balance = 0; $tlt_balance_amt = 0;
                foreach($banks as $bank)
                {
                    
                    $tlt_debit = $bank->balance->sum('debit');
                    $tlt_credit = $bank->balance->sum('credit');

                    $tlt_balance = $tlt_credit - $tlt_debit;

                    $data['banks'][] = [
                        'id' => $bank->id,
                        'code' => $bank->code,
                        'name' => $bank->name,
                        'opening' => number_format($bank['opening_balance'], 2),
                        'balance_type' => $bank['balance_type'],
                        'debit' => $tlt_debit,
                        'credit' => $tlt_credit,
                        'tlt_balance' => number_format($bank['opening_balance']+ $tlt_balance, 2),
                       
                    ];

                     $tlt_balance_amt = $tlt_balance_amt + $tlt_balance;
                }

                $data['tlt_balance_amt'] = number_format($tlt_balance_amt, 2);

            }

            $data['currency'] = $this->custom->currencyFormatSymbol();
            
            return view('accounting.reports.bankandcash', $data);
            
        } catch (ModelNotFoundException $e) {
            
        }
    }


    public function export(Request $request)
    {
        try {

            $action = $request->type;
            switch ($action) {
                case 'bankCash':

                    Excel::create(__('admin/reports.bank_and_cash_text'), function($excel) {
                        $excel->sheet(__('admin/reports.bank_and_cash_text'), function($sheet){

                            $sheet->mergeCells('A1:C1');
                            $sheet->setHeight(1, 50);
                            $sheet->cells('A1:C1', function($cells) {
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                                $cells->setFont(array(
                                        'family'     => 'Calibri',
                                        'size'       => '14',
                                        'bold'       => true
                                    )
                                );
                            });

                            $sheet->cells('A2:C2', function($cells) {
                                $cells->setFont(array(
                                        'bold'       => true
                                    )
                                );
                            });

                            $sheet->row(1, array(__('admin/reports.bank_and_cash_text')));
                            
                            $sheet->row(2, array(__('admin/reports.code_txt'), __('admin/entries.payment_bank_label'), __('admin/entries.balace_amount_txt')));

                             $type_id = 9;
                             $banks = AccountsChart::select('id','code', 'name', 'opening_balance', 'balance_type')->whereTypeId($type_id)->get();

                            $data['tlt_balance_amt'] = 0;
                            if(isset($banks))
                            {
                                $tlt_debit = 0; $tlt_credit = 0; $tlt_balance = 0; $tlt_balance_amt = 0;
                                $r = 3;
                                foreach($banks as $bank)
                                {

                                    $tlt_debit = $bank->balance->sum('debit');
                                    $tlt_credit = $bank->balance->sum('credit');

                                    $tlt_balance = $tlt_credit - $tlt_debit;

                                    $sheet->cells('A'.$r.':C'.$r.'', function($cells) {
                                        $cells->setAlignment('right');
                                        $cells->setValignment('center');
                                    });

                                    $sheet->appendRow($r, array(
                                        $bank->code,
                                        $bank->name, 
                                        number_format($tlt_balance, 2)
                                    ));

                                    $tlt_balance_amt = $tlt_balance_amt + $tlt_balance;

                                    $r++;
                                }

                                $data['tlt_balance_amt'] = number_format($tlt_balance_amt, 2);

                            }


                        });
                    })->export('xls');  

                   
                   
                break;
                
                default:
                break;
            }
            
        } catch (ModelNotFoundException $e) {
            
        }
    }
}
