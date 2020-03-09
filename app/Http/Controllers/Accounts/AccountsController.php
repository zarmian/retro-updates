<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Accounts\AccountsSummeryDetail;
use App\Http\Models\Accounts\AccountsSummery;
use App\Http\Models\Accounts\PurchaseLedger;
use App\Http\Models\Accounts\AccountsChart;
use App\Http\Models\Accounts\AccountsType;
use App\Http\Models\Accounts\SalesLedger;
use App\Http\Controllers\Controller;
use App\Http\Models\Accounts\Sales;
use Illuminate\Http\Request;
use App\Libraries\Customlib;
use Carbon\Carbon;
use Config;
use Mail;
use Auth;
use DB;


class AccountsController extends Controller
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

        $str_month = date('Y-m'.'-01', time());
        $end_month = date('Y-m'.'-01', strtotime("-6 month"));

        $end  = strtotime($str_month);
        $start = $month = strtotime($end_month);

        $inc = [];
        $exp = [];
        $montly_income = $this->getIncomebymonth();
        $montly_expense = $this->getExpensebymonth();

        while ($month <= $end) {

            $total_month[] = date('M Y', $month);
            $m = date('m', $month);

            $key = "month";
            $return = $this->whatever($montly_income, $key, $m);
            if ($return) {
                $inc[] = $return;
            }else{
                $inc[] = '0.00';
            }

            $eReturn = $this->whatever($montly_expense, $key, $m);
            if($eReturn)
            {
                $exp[] = $eReturn;
            }else{
                $exp[] = '0.00';
            }


            $month = strtotime("+1 month", $month);
        }


        $data['total_month'] = $total_month;
        $data['monthly_income'] = $inc;
        $data['montly_expense'] = $exp;

        $data['recents'] = $this->recentsInvoices(5);
        $data['status'] = $this->invoiceStatus();
        $data['payments'] = $this->salesPayments(5);
        $data['vouchers'] = $this->purchasePayments(5);
        $data['total_month_incom'] = $this->getTotalMonthlyIncome();
        $data['total_month_expense'] = $this->getTotalMonthlyExpense();

        $data['total_receivable'] = $this->getTotalReceivable();
        $data['total_payable'] = $this->getTotalPayable();

        $data['total_month_incom'] = number_format($data['total_month_incom'], 2);
        $data['total_month_expense'] = number_format($data['total_month_expense'], 2);

        $data['total_pie'] = [$this->custom->intCurrency($data['total_month_incom']), $this->custom->intCurrency($data['total_month_expense'])];

        $data['currency'] = $this->custom->currencyFormatSymbol();

        return view('accounting.index', $data);
         

      } catch (ModelNotFoundException $e) {
          
      }
    }


    public function getIncomebymonth()
    {
        try {
            
            $ch = DB::table('tbl_sales')
              ->select(DB::raw('MONTH(invoice_date) as month, YEAR(invoice_date) as year, SUM(total) as t'))
              ->whereRaw('invoice_date > DATE_SUB(now(), INTERVAL 6 MONTH)')
              ->groupBy(DB::raw('YEAR(invoice_date), MONTH(invoice_date)'))
              ->get()->toArray();
              $inc = [];
              if(isset($ch) && count($ch) > 0)
              {
                foreach($ch as $c)
                {
                    $inc[] = [
                        'month' => $c->month,
                        'year' => $c->year,
                        'amount' => $c->t
                    ];
                }
              }
            return $inc;

        } catch (ModelNotFoundException $e) {
            
        }
    }



    public function getExpensebymonth(){

        try {

            $ch = DB::table('tbl_purchase')
              ->select(DB::raw('MONTH(invoice_date) as month, YEAR(invoice_date) as year, SUM(total) as t'))
              ->whereRaw('invoice_date >= DATE_SUB(now(), INTERVAL 6 MONTH)')
              ->groupBy(DB::raw('YEAR(invoice_date), MONTH(invoice_date)'))
              ->get()->toArray();
              $inc = [];
              if(isset($ch) && count($ch) > 0)
              {
                foreach($ch as $c)
                {
                    $inc[] = [
                        'month' => $c->month,
                        'year' => $c->year,
                        'amount' => $c->t
                    ];
                }
              }
            return $inc;

        } catch (ModelNotFoundException $e) {
            
        }
    }



    public function whatever($array, $key, $val) {
        foreach ($array as $item)
            if (isset($item[$key]) && $item[$key] == $val)
                return $item['amount'];
            return false;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getTotalReceivable()
    {
        try {

            $receivable = Sales::select(DB::raw('SUM(total) as tlt_amt'))->first();
            $row = SalesLedger::select(DB::raw('SUM(amount) as tlt_paid'))->first();

            if(isset($receivable->tlt_amt) && $receivable->tlt_amt <> 0){
                return number_format($receivable->tlt_amt - $row->tlt_paid, 2);
            }else{
              return '0.00';
                
            }
            
        } catch (ModelNotFoundException $e) {
            
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getTotalPayable()
    {
        try {

            $payable = DB::table('tbl_purchase')
              ->select(
                DB::raw('SUM(tbl_purchase.total) as t'),
                DB::raw('(SELECT SUM(tbl_purchase_ledger.amount) FROM `tbl_purchase_ledger` ) as tlt_paid')
            )->first();

            
            if(isset($payable->t) && $payable->t <> 0){
              return number_format($payable->t - $payable->tlt_paid, 2);
            }else{
              return number_format(0, 2);
            }

            
            
        } catch (ModelNotFoundException $e) {
            
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTotalMonthlyIncome(){

        try {
            
            $incom = DB::table('tbl_sales_ledger')
              ->select(DB::raw('MONTH(date) as month, YEAR(date) as year, 
                SUM(amount) as t'))
              ->whereRaw('MONTH(date) = MONTH(CURRENT_DATE())')
              ->groupBy('month')
              ->first();

              if(isset($incom) && count($incom) > 0)
              {
                return ($incom->t);
              }else{
                return '0.00';
              }

        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getTotalMonthlyExpense(){

        try {
            
            $expense = DB::table('tbl_purchase_ledger')
              ->select(
                    DB::raw('MONTH(date) as month, YEAR(date) as year, 
                    SUM(amount) as t')
                )
              ->where(DB::raw('MONTH(date)'), '=', date('n'))
              //->whereRaw('MONTH(date) = MONTH(CURRENT_DATE())')
              ->groupBy('date')
              ->first();

              if(isset($expense) && count($expense) > 0)
              {
                $journal = $this->getTotalMonthlyJournalEntry();
                return $expense->t + $journal['cr'];
              }else{
                return '0.00';
              }
        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function getTotalMonthlyJournalEntry(){

        try {

            $journals = AccountsSummery::select(
                    DB::raw('
                      tbl_accounts_summery.id')
              )
              ->where(DB::raw('MONTH(tbl_accounts_summery.date)'), '=', date('n'))
              ->where('tbl_accounts_summery.type', '1')
              ->get();

              
              $jr = ['cr' => '0.00'];
              if(isset($journals) && count($journals) > 0)
              {
                $amount = 0;
                $debit = 0;
                foreach($journals as $journal)
                {
                  $amount += $journal->amount->sum('credit');

                }
                
                $jr = ['cr' => $amount];
                
              }
              //print_r($jr);
              return $jr;


        } catch (ModelNotFoundException $e) {
            
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function getTodayJournalEntry(){

        try {

            $journal = DB::table('tbl_accounts_chart')
              ->select(
                    DB::raw('
                        MONTH(tbl_accounts_summery_detail.date) as month, 
                        YEAR(tbl_accounts_summery_detail.date) as year, 
                        SUM(tbl_accounts_summery_detail.debit) as dr,
                        SUM(tbl_accounts_summery_detail.credit) as cr,
                        tbl_accounts_summery_detail.account_id,
                        tbl_accounts_chart.id,
                        tbl_accounts_chart.type_id
                    ')
                )
              ->Join('tbl_accounts_summery_detail', 'tbl_accounts_summery_detail.account_id', '=', 'tbl_accounts_chart.id')
              //->where(DB::raw('MONTH(tbl_accounts_summery_detail.date)'), '=', date('n'))
              ->whereRaw('Date(tbl_accounts_summery_detail.date) = CURDATE()')
              ->where('tbl_accounts_chart.type_id', '15')
              ->groupBy('tbl_accounts_summery_detail.account_id', 'tbl_accounts_summery_detail.date', 'tbl_accounts_chart.id', 'tbl_accounts_chart.type_id')
              ->first();

              
              $jr = ['dr' => '0.00', 'cr' => '0.00'];
              if(isset($journal) && count($journal) > 0)
              {
               
                $jr = [
                    'month' => $journal->month,
                    'year' => $journal->year,
                    'dr' => $journal->dr,
                    'cr' => $journal->cr,
                    'account_id' => $journal->account_id,
                    'id' => $journal->id,
                    'type_id' => $journal->type_id,
                ];
                
              }

              return $jr;


        } catch (ModelNotFoundException $e) {
            
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function recentsInvoices($limit = NULL, $id = NULL){

        try {
            if(is_null($limit)) $limit = 0;

            $sales = Sales::query();

            $sales->select(
                'id',
                'invoice_number',
                'invoice_date',
                'sub_total',
                'discount',
                'paid_status',
                'customer_id'
            );
            if(isset($id) && !is_null($id) && $id <> "")
            {
              $sales->where('customer_id', $id);
            }
            $sales->limit($limit);
            $sales->orderBy('id', 'desc');
            $rows = $sales->get();

            $s = [];
            if(isset($rows) && count($rows) > 0)
            {
                foreach($rows as $sale)
                {
                  
                    $s[] = [
                        'id' => $sale->id,
                        'invoice_number' => $sale->invoice_number,
                        'date' => $sale->invoice_date,
                        'amount' => number_format($sale->sub_total - $sale->discount, 2),
                        'paid' => $sale->paid_status,
                        'customer' => $sale->customer->first_name.' '.$sale->customer->last_name
                    ];
                }
            }

            return $s;
        } catch (ModelNotFoundException $e) {
            
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function invoiceStatus()
    {
        try {

            $status = [];

            $sales = Sales::select(
                
                DB::raw('(
                    SELECT COUNT(s.paid_status) FROM `tbl_sales` s
                    WHERE s.paid_status = "1"
                ) AS tlt_paid'),
                DB::raw('(
                    SELECT COUNT(s.paid_status) FROM `tbl_sales` s
                    WHERE s.paid_status = "2"
                ) AS tlt_partial'),
                DB::raw('(
                    SELECT COUNT(s.paid_status) FROM `tbl_sales` s
                    WHERE s.paid_status = "3"
                ) AS tlt_unpaid')
            )->first();

            if(isset($sales) && count($sales) > 0)
            {
              $total_invoices = $sales->tlt_paid + $sales->tlt_partial + $sales->tlt_unpaid;
            
              $status = [
                  'paid' => $sales->tlt_paid,
                  'partial' => $sales->tlt_partial,
                  'unpaid' => $sales->tlt_unpaid,
                  'unpaid_percent' => $sales->tlt_unpaid / $total_invoices * 100,
                  'partial_percent' => $sales->tlt_partial / $total_invoices * 100,
                  'paid_percent' => $sales->tlt_paid / $total_invoices * 100,
              ];

              return $status;
            }

            
           
        } catch (ModelNotFoundException $e) {
            
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function salesPayments($limit = NULL)
    {
        try {
            
            if(is_null($limit)) $limit = 0;

            $p = [];

            $payments = SalesLedger::orderBy('date', 'DESC')->limit($limit)->get();
            if(isset($payments) && count($payments) > 0)
            {
                foreach($payments as $payment)
                {
                    $p[] = [
                        'sale_id' => $payment->sale_id,
                        'account_id' => $payment->account_id,
                        'customer_id' => $payment->customer_id,
                        'payment_no' => $payment->payment_no,
                        'date' => $this->custom->dateformat($payment->date),
                        'references' => $payment->references,
                        'amount' => number_format($payment->amount, 2),
                        'description' => $payment->description,
                    ];
                }
            }

            return $p;


        } catch (ModelNotFoundException $e) {
            
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function purchasePayments($limit = NULL)
    {
        try {
            
            if(is_null($limit)) $limit = 0;

            $p = [];

            $payments = PurchaseLedger::orderBy('date', 'DESC')->limit($limit)->get();
            if(isset($payments) && count($payments) > 0)
            {
                foreach($payments as $payment)
                {
                    $p[] = [
                        'sale_id' => $payment->sale_id,
                        'account_id' => $payment->account_id,
                        'customer_id' => $payment->customer_id,
                        'payment_no' => $payment->payment_no,
                        'date' => $this->custom->dateformat($payment->date),
                        'references' => $payment->references,
                        'amount' => number_format($payment->amount, 2),
                        'description' => $payment->description,
                    ];
                }
            }

            return $p;


        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTodayReceivable()
    {
      try {
        //->whereRaw('invoice_date > DATE_SUB(now(), INTERVAL 6 MONTH)')
        $receivable = DB::table('tbl_sales')
          ->select(DB::raw('
            MONTH(tbl_sales.invoice_date) as month, 
            YEAR(tbl_sales.invoice_date) as year, 
            SUM(tbl_sales.total) as total,
            SUM(tbl_sales_ledger.amount) as paid,
            SUM(tbl_sales.total) - SUM(tbl_sales_ledger.amount) as tlt_payable'
        ))
        ->leftJoin('tbl_sales_ledger', 'tbl_sales_ledger.sale_id', '=', 'tbl_sales.id')
        ->whereRaw('Date(tbl_sales.invoice_date) = CURDATE()')
        ->groupBy('tbl_sales.invoice_date')
        ->first();

        if(isset($receivable) && count($receivable) <> 0){
            return number_format($receivable->total - $receivable->paid, 2);
        }else{
            return '0.00';
        }

      } catch (ModelNotFoundException $e) {
        
      }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTodayPayable()
    {
      try {
        //->whereRaw('invoice_date > DATE_SUB(now(), INTERVAL 6 MONTH)')
        $receivable = DB::table('tbl_purchase')
          ->select(DB::raw('
            MONTH(tbl_purchase.invoice_date) as month, 
            YEAR(tbl_purchase.invoice_date) as year, 
            SUM(tbl_purchase.total) as total,
            SUM(tbl_purchase_ledger.amount) as paid,
            SUM(tbl_purchase.total) - SUM(tbl_purchase_ledger.amount) as tlt_payable'
        ))
        ->leftJoin('tbl_purchase_ledger', 'tbl_purchase_ledger.sale_id', '=', 'tbl_purchase.id')
        ->whereRaw('Date(tbl_purchase.invoice_date) = CURDATE()')
        ->groupBy('tbl_purchase.invoice_date')
        ->first();


        if(count($receivable) == 0){
            return number_format(0, 2);
        }else{
            return number_format($receivable->total - $receivable->paid, 2);
        }

      } catch (ModelNotFoundException $e) {
        
      }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function chart()
    {
        try {
            
            $data = [];

            $accounts = AccountsType::whereParent('0')->get();
            if(isset($accounts) && count($accounts) > 0)
            {
                foreach($accounts as $account)
                {

                   $coa = [];
                    if(isset($account->children) && count($account->children) > 0)
                    {
                        foreach($account->children as $child)
                        {
                            
                            if(isset($child->chartofacc) && count($child->chartofacc) > 0){


                                foreach($child->chartofacc as $ac){
                                    $balance_type = '';
                                    $opening = '';
                                    if($ac->opening_balance > 0)
                                    {
                                      $balance_type = $ac->balance_type;
                                      $opening = $ac->opening_balance; 
                                    }
                                    $coa[] = [
                                        'id' => $ac->id,
                                        'name' => $ac->name,
                                        'code' => $ac->code,
                                        'cid' => $ac->cid, 
                                        'type_id' => $ac->type_id,
                                        'opening' => $opening,
                                        'balance_type' => $balance_type,
                                        'is_systemize' => $ac->is_systemize,
                                        'type_name' => $ac->type->name,
                                        'balance' => $this->account_balance($ac->cid)
                                    ];
                                }
                            }
                            
                            
                        }
                    }

                    $coa = array_values(array_sort($coa, function ($value) {
                        return $value['code'];
                    }));
                    

                    $accounts_data[] = [
                        'id' => $account->id,
                        'name' => $account->name,
                        'coa' => $coa
                    ];
                }
            }



            $data['total_receivable'] = $this->getTotalReceivable();
            $data['total_payable'] = $this->getTotalPayable();
            $data['today_receivable'] = $this->getTodayReceivable();
            $data['today_payable'] = $this->getTodayPayable();
            $data['today_expense'] = $this->getTodayJournalEntry();
            $data['total_expense'] = $this->getTotalMonthlyJournalEntry();
            $data['this_month_salary'] = $this->getSalaryByMonth(date('Y-m-d', time()));
            $data['pervious_month_salary'] = $this->getSalaryByMonth(date('Y-m-d', strtotime('-1 MONTH')));


            $data['today_expense'] = number_format($data['today_expense']['cr'], 2);
            $data['total_expense'] = number_format($data['total_expense']['cr'], 2);

            $data['currency'] = $this->custom->currencyFormatSymbol();

            return view('accounting.chart.index', ['accounts' => $accounts_data], $data);
            

        } catch (ModelNotFoundException $e) {
            
        }
    }


    protected function getSalaryByMonth($date = '')
    {
      try {

        $row = DB::table('tbl_employees_ledger')->select(DB::raw('SUM(amount) as tlt_amt'))->whereMonth('date', '=', date('m', strtotime($date)))->groupBy('employee_id')->first();
        
        if(isset($row) && count($row) > 0)
        {
          return $row->tlt_amt;
        }
        return '0.00';
        
      } catch (ModelNotFoundException $e) {
        return '0.00';
      }
    }



    protected function account_balance($account_id='')
    {

      try {
          
        $row = AccountsChart::findOrFail($account_id);
        $ac_row = AccountsSummeryDetail::select(DB::raw('account_id, SUM(debit) as dr, SUM(credit) as cr'))->where('account_id', $account_id)->groupBy('account_id')->first();

        if($row->balance_type == 'cr'){
          return $row->opening_balance + $ac_row['cr'] - $ac_row['dr'];
        }else{
          return $row->opening_balance + $ac_row['dr'] - $ac_row['cr'];
        }
        
      } catch (Exception $e) {
        
      }
    }


    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            

            $data = [];

            $types = AccountsType::where('parent', '0')->get();

            if(isset($types) && count($types) > 0)
            {
                foreach($types as $type)
                {

                    $children = [];
                    if(isset($type->children) && count($type->children) > 0)
                    {
                        foreach($type->children as $child)
                        {
                            $children[] = [
                                'type_id' => $child->id,
                                'name' => $child->name,
                                'parent' => $child->parent
                            ];
                        }
                    }

                    $data['types'][] = [
                        'type_id' => $type->id,
                        'name' => $type->name,
                        'parent' => $type->parent,
                        'children' => $children

                    ];

                }
            }

            return view('accounting.chart.create', $data);

        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            
            $this->validate($request, [
                'name' => 'required',
                'code' => 'required|unique:tbl_accounts_chart',
                'account_type' => 'required',
                'balance_type' => 'required',
            ]);

            $chart = new AccountsChart;
            $chart->code = $request->input('code');
            $chart->name = $request->input('name');
            $chart->type_id = $request->input('account_type');
            $chart->opening_balance = $request->input('opening');
            $chart->balance_type = $request->input('balance_type');
            $chart->is_systemize = '0';
            $chart->save();

            if($chart)
            {
                $request->session()->flash('msg', __('admin/accounting.coa_added'));
            }

            return redirect('accounting/chart/add');


        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function edit($id=NULL)
    {
        try {
            
            if(is_null($id)) return redirect('accounting/chart');

            $data = [];

            $data['chart'] = AccountsChart::findOrFail($id);


            $types = AccountsType::where('parent', '0')->get();

            if(isset($types) && count($types) > 0)
            {
                foreach($types as $type)
                {

                    $children = [];
                    if(isset($type->children) && count($type->children) > 0)
                    {
                        foreach($type->children as $child)
                        {
                            $children[] = [
                                'type_id' => $child->id,
                                'name' => $child->name,
                                'parent' => $child->parent
                            ];
                        }
                    }

                    $data['types'][] = [
                        'type_id' => $type->id,
                        'name' => $type->name,
                        'parent' => $type->parent,
                        'children' => $children

                    ];

                }
            }


            return view('accounting.chart.edit', $data);

        } catch (ModelNotFoundException $e) {
            return redirect('accounting/chart');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Accounts\Accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id=NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/chart');

            $chart = AccountsChart::findOrFail($id);
            
            $this->validate($request, [
                'name' => 'required',
                'account_type' => 'required',
                'balance_type' => 'required',
            ]);

            
            $chart->name = $request->input('name');
            $chart->type_id = $request->input('account_type');
            $chart->opening_balance = $request->input('opening');
            $chart->balance_type = $request->input('balance_type');
            $chart->is_systemize = '0';
            $chart->save();

            if($chart)
            {
                $request->session()->flash('msg', __('admin/accounting.coa_updatd'));
            }

            return redirect('accounting/chart/edit/'.$id);


        } catch (ModelNotFoundException $e) {
            return redirect('accounting/chart');
        }
    }

}