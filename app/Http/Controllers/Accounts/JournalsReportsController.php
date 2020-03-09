<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Accounts\AccountsSummeryDetail;
use App\Http\Models\Accounts\AccountsSummery;
use App\Http\Models\Accounts\AccountsChart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Customlib;
use Carbon\Carbon;
use DB;


class JournalsReportsController extends Controller
{


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

            $accounts = AccountsChart::whereTypeId('15')->get();
            if(isset($accounts) && count($accounts) > 0)
            {
                foreach($accounts as $account)
                {
                    $data['accounts'][] = [
                        'id' => $account['id'],
                        'code' => $account['code'],
                        'name' => $account['name']
                    ];
                }
            }
  
            return view('accounting.reports.expense', $data);
            
        } catch (ModelNotFoundException $e) {
            
        }
    }


    public function getExpenseReport(Request $request)
    {
        try {

            $data = [];
            $data['accounts'] = [];
            $data['summery'] = [];

            $data['to'] = $request->input('to');
            $data['from'] = $request->input('from');
            $account = $request->input('account');
            

            $nice_to_date = Carbon::createFromFormat('m/d/Y', $data['to'])->toDateString();
            $nice_from_date = Carbon::createFromFormat('m/d/Y', $data['from'])->toDateString();


            $query = AccountsSummery::query();

            $query->select(DB::raw('
                tbl_accounts_summery.id,
                tbl_accounts_summery.code, 
                tbl_accounts_summery.date, 
                tbl_accounts_chart.name,
                tbl_accounts_summery.description sdescription,
                tbl_accounts_summery_detail.description as ddescription,
                tbl_accounts_summery_detail.debit,
                tbl_accounts_summery_detail.credit,
                SUM(tbl_accounts_summery_detail.credit) as tlt_cr,
                SUM(tbl_accounts_summery_detail.debit) as tlt_dr
            '));
            if(isset($account) && $account <> "")
            {
                $query->whereAccountId($account);
            }
            else
            {
                $query->where('tbl_accounts_summery.date', '>=', $nice_to_date);
                $query->where('tbl_accounts_summery.date', '<=', $nice_from_date);
            }

            $query->join('tbl_accounts_summery_detail', 'tbl_accounts_summery.id', '=', 'tbl_accounts_summery_detail.summery_id');

            $query->join('tbl_accounts_chart', 'tbl_accounts_chart.id', '=', 'tbl_accounts_summery_detail.account_id');
            
            $query->where('tbl_accounts_chart.type_id', '15');
            $query->whereType('1');
            $query->groupBy('tbl_accounts_summery.id');
            $sumerys = $query->get();

            $payment_detail = '';
            if(isset($sumerys) && count($sumerys) > 0)
            {
                $tlt_credit=0;$tlt_debit=0;
                foreach($sumerys as $summery)
                {

                    if(isset($summery['debit']) && $summery['debit'] > 0){
                        $payment_detail = $this->getStatmentDebit($summery['id']);
                    }else{
                        $payment_detail = $this->getStatmentCredit($summery['id']);
                    }


                    $data['summery'][] = [
                        'id' => $summery['id'],
                        'code' => $summery['code'],
                        'bank_name' => $summery['name'],
                        'sdescription' => $summery['sdescription'],
                        'ddescription' => $summery['ddescription'],
                        'date' => $this->custom->dateformat($summery['date']),
                        'debit' => number_format($summery['tlt_dr'], 2),
                        'credit' => number_format($summery['tlt_cr'], 2),
                        'payment_detail' => $payment_detail,
                        
                    ];

                    $tlt_credit = $tlt_credit + $summery['tlt_cr'];
                    $tlt_debit = $tlt_debit + $summery['tlt_dr'];
                }

                $data['tlt_credit'] = number_format($tlt_credit, 2);
                $data['tlt_debit'] = number_format($tlt_debit, 2);


            }


            $accounts = AccountsChart::whereTypeId('15')->get();
            if(isset($accounts) && count($accounts) > 0)
            {
                foreach($accounts as $account)
                {
                    $data['accounts'][] = [
                        'id' => $account['id'],
                        'code' => $account['code'],
                        'name' => $account['name']
                    ];
                }
            }



            $data['currency'] = $this->custom->currencyFormatSymbol();
            return view('accounting.reports.expense', $data);
            
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
}
