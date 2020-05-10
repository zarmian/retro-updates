<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Accounts\AccountsSummeryDetail;
use App\Http\Models\Accounts\AccountsSummery;
use App\Http\Models\Accounts\AccountsChart;
use App\Http\Models\Accounts\AccountsType;
use App\Http\Models\Accounts\Journal;
use App\Http\Models\Accounts\Payment;
use App\Http\Models\Accounts\Sales;
use App\Http\Models\Accounts\SalesLedger;
use App\Http\Models\Accounts\Customers;
use App\Http\Controllers\Controller;
use App\Libraries\Customlib;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Storage;
use Auth;
use DB;

class PaymentsReceivedController extends Controller
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
            $data['journals'] = [];

            $data['per_page'] = \Request::get('per_page') ?: 12;

            $qry = AccountsSummery::query();

            if(\Request::has('code'))
            {
                $code = \Request::get('code');
                $qry->where('code', $code); 
            }elseif(\Request::has('date')){
                $date = \Request::get('date');
                $nice_date = Carbon::createFromFormat('m/d/Y', $date)->toDateString();
                $qry->whereDate('date', $nice_date);
            }

            $journals = $qry->where('type', '8')->orderBy('code', 'DESC')->paginate($data['per_page']);

            $amount = 0;


            if(isset($journals) )
            {
                foreach($journals as $journal)
                {
                    $name =[];
                    $amount = $journal->amount->sum('credit');
                    if(isset($journal->details) )
                {
                    foreach($journal->details as $detail)
                    {
                        $qry=AccountsChart::findOrFail($detail->account_id);
                        $name[]=$qry->name;
                    }
                }
                    
                    
                    $data['journals'][] = [
                        'id' => $journal->id,
                        'code' => $journal->code,
                        'date' => $this->custom->dateformat($journal->date),
                        'reference' => $journal->reference,
                        'description' => $journal->description,
                        'from'=>$name[0],
                        'to' =>$name[1],
                        'type' => $journal->type,
                        'amount' => $this->custom->currenyFormat($amount),
                    ];
                }
            }

            $data['pages'] = $journals->appends(\Input::except('page'))->render();

            return view('accounting/recieve/index', $data);

        } catch (ModelNotFoundException $e) {
            
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

            $expense_data = [];
            $bank_data = [];

            $expense_accounts = AccountsChart::whereTypeId('17')->get();
            if(isset($expense_accounts) )
            {
                foreach($expense_accounts as $expense)
                {
                    $expense_data[] = [
                        'id' => $expense['id'],
                        'code' => $expense['code'],
                        'name' => $expense['name']
                    ];
                }
            }


            $bank_accounts = AccountsChart::whereTypeId('22')->get();
            if(isset($bank_accounts) )
            {
                foreach($bank_accounts as $bank)
                {
                    $bank_data[] = [
                        'id' => $bank['id'],
                        'code' => $bank['code'],
                        'name' => $bank['name']
                    ];
                }
            }


            $invoice_number = '00001';

            $journal = DB::table('tbl_accounts_summery')
            ->select('code')
            ->where('type', '8')
            ->orderBy('code', 'DESC')
            ->first();
            if($journal)
            {
                $invoice_no = $this->getInteger($journal->code);
                
                $code = str_pad($invoice_no + 1, 5, 0, STR_PAD_LEFT);
            }
            

          
            // $code = $this->custom->getJournalCode();

            return view('accounting/recieve/create', ['accounts' => $expense_data, 'code' => $code, 'banks' => $bank_accounts]);

        } catch (ModelNotFoundException $e) {
            
        }

    }


    public function getInteger($string)
    {
        return preg_replace("/[^0-9]/", '', $string);
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

            $rules = [
                'date' => 'required',
                'code' => 'required|unique:tbl_accounts_summery,code,null,null,type,8',
            ];

            $this->validate($request, $rules);
            

            $date = $request->input('date');
            $nice_date =  Carbon::createFromFormat('m/d/Y', $date)->toDateString();
            $code = $request->input('code');
            $ref = $request->input('ref');
            $summery = $request->input('summery');
            $create_by = Auth::guard('auth')->user()->id;


            $jr = [
                'date' => $nice_date,
                'code' => $code,
                'reference' => $ref,
                'description' => $summery,
                'type' => '8',
                'added_by' => $create_by,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $id = AccountsSummery::insertGetId($jr);

            if($id){

                $line_debit = $request->input('line_debit');
                $line_credit = $request->input('line_credit');
                $account_type = $request->input('account_type');
                $line_desc = $request->input('line_desc');

              
                $account_type_count = count($account_type);
                if(isset($account_type_count) && $account_type_count > 0)
                {
                    
                    $debit = 0; $credit = 0;
                    $detail = [];
                    for($i = 0; $i < $account_type_count; $i++)
                    {

                        $credit = ($line_credit[$i] == 0 || $line_credit[$i] == '') ? 0 : $line_credit[$i];

                        $debit = ($line_debit[$i] == 0 || $line_debit[$i] == '') ? 0 : $line_debit[$i];
                        
                        // if($line_debit[$i] <> "" && $line_credit[$i] <> "")
                        // {
                            $detail[] = [
                                'summery_id' => $id,
                                'account_id' => $account_type[$i],
                                'date' => $nice_date,
                                'debit' => $debit, 
                                'credit' => $credit,
                                'description' => $line_desc[$i],
                                'added_by' => $create_by,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ];
                        //}
                    }
                    
                    AccountsSummeryDetail::insert($detail);

                    //Auto Payment clear
                    $code1=AccountsChart::Select('code')->where('id',$account_type[0])->first();
                    // dd($code1);
                    $qry2=Customers::Select('id')->where('code',$code1->code)->first();
                    $balance1=Payment::where('customer_id',$account_type[0])->first();
                    $amount=$line_debit[0] + $balance1->balance;
                    $customer_id =$qry2->id;

                    

                    $sales=$qry2->sales->where('paid_status','2');
                    
                    if(isset($sales))
                    {
                        
                        
                        {
                        foreach($sales as $sale)
                        {  $payment_number= $this->custom->getPaymentNumber();
                           $sale1 = Sales::findOrFail($sale->id);
                           $tlt_paid = $sale1->paid->sum('amount');
                           $tlt_amount = $sale1->sub_total - $sale1->discount;
                           $remaining= $tlt_amount - $tlt_paid;
                           if($amount > 0 )
                           {
                           if($amount > $remaining)
                           {
                               $pay_amount=$remaining;
                               $amount= $amount-$remaining;
                           }
                           elseif($amount == $remaining )
                           {
                            $pay_amount=$remaining;
                               $amount= $amount-$remaining;
                           }
                           elseif($amount < $remaining)
                           {
                            
                            $pay_amount=$amount;
                            $amount=0;
                           }
                           
                            $ledger = new SalesLedger;
                            $ledger->sale_id = $sale->id;
                            $ledger->account_id = $account_type[1];
                            $ledger->customer_id = $customer_id;
                            $ledger->payment_no = $payment_number;
                            $ledger->date = $date;
                            $ledger->references = $code;
                            $ledger->amount = $pay_amount;
                            $ledger->added_by = $create_by;
                            $ledger->save();
                           
                           $u_sale = Sales::findOrFail($sale1->id);

                            $tlt_paid_sum = $u_sale->paid->sum('amount');
                            $tlt_amount_sum = $u_sale->sub_total - $u_sale->discount;
                            $is_total_paid = $tlt_amount_sum - $tlt_paid_sum;

                            $partial_paid = $tlt_paid_sum*0.50;
                            $half_payment = $tlt_amount_sum / 2;

                            $is_partial = ($half_payment >= $partial_paid) ? 1 : 0;
                            
                            $status = 3;

                           
                            if($is_total_paid == 0){
                                $status = 1;
                            }elseif($is_partial == 1 && ($is_total_paid) <> 0){
                                $status = 2;
                            }elseif($tlt_paid_sum <=0){
                                $status = 3;
                            }

                            $u_sale->paid_status = $status;
                            $u_sale->save();
                        }
                            
                        }
                     
                    }
                        
                    }
                    $sales=$qry2->sales->where('paid_status','3');
                    
                    if(isset($sales))
                    {
                        
                        {
                        foreach($sales as $sale)
                        {  $payment_number= $this->custom->getPaymentNumber();
                           $sale1 = Sales::findOrFail($sale->id);
                           $tlt_paid = $sale1->paid->sum('amount');
                           $tlt_amount = $sale1->sub_total - $sale1->discount;
                           $remaining= $tlt_amount - $tlt_paid;
                           if($amount> 0 )
                           {
                           if($amount > $remaining)
                           {
                               $pay_amount=$remaining;
                               $amount= $amount-$remaining;
                           }
                           elseif($amount == $remaining )
                           {
                            $pay_amount=$remaining;
                               $amount= $amount-$remaining;
                           }
                           elseif($amount < $remaining)
                           {
                            
                            $pay_amount=$amount;
                            $amount=0;
                           }
                           
                            $ledger = new SalesLedger;
                            $ledger->sale_id = $sale->id;
                            $ledger->account_id = $account_type[1];
                            $ledger->customer_id = $customer_id;
                            $ledger->payment_no = $payment_number;
                            $ledger->date = $date;
                            $ledger->references = $code;
                            $ledger->amount = $pay_amount;
                            $ledger->added_by = $create_by;
                            $ledger->save();
                           
                           $u_sale = Sales::findOrFail($sale1->id);

                            $tlt_paid_sum = $u_sale->paid->sum('amount');
                            $tlt_amount_sum = $u_sale->sub_total - $u_sale->discount;
                            $is_total_paid = $tlt_amount_sum - $tlt_paid_sum;

                            $partial_paid = $tlt_paid_sum*0.50;
                            $half_payment = $tlt_amount_sum / 2;

                            $is_partial = ($half_payment >= $partial_paid) ? 1 : 0;
                            
                            $status = 3;

                           
                            if($is_total_paid == 0){
                                $status = 1;
                            }elseif($is_partial == 1 && ($is_total_paid) <> 0){
                                $status = 2;
                            }elseif($tlt_paid_sum <=0){
                                $status = 3;
                            }

                            $u_sale->paid_status = $status;
                            $u_sale->save();
                        }
                            
                        }
                     }

                        
                    }
                    $balance1=Payment::where('customer_id',$account_type[0])->first();
                            if(isset($balance1))
                            {
                                
                                $balance1->balance=$amount;
                                $balance1->save();
                            }
                            else{
                                $add= new Payment;
                                $add->customer_id = $account_type[0];
                                $add->balance = $amount;
                                $add->save();
                            }

                }
                

                $request->session()->flash('msg', 'Payment Voucher has been added sucssfully.');

                return redirect('accounting/payments/received/add');

            }
            

        } catch (ModelNotFoundException $e) {
            return redirect('accounting/journal');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function edit($id = NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/payments/received');

            $journal = AccountsSummery::where('type', '8')->findOrFail($id);
            if(isset($journal) )
            {
                
                $dt = Carbon::parse($journal->date);

                $d['details'] = [];
                $tlt_dr = 0; $tlt_cr = 0;
                if(isset($journal->details) )
                {
                    foreach($journal->details as $detail)
                    {

                        $d['details'][] = [
                            'summery_id' => $detail->summery_id,
                            'account_id' => $detail->account_id,
                            'date' => $detail->date,
                            'debit' => $detail->debit,
                            'credit' => $detail->credit,
                            'description' => $detail->description,
                            'types' => $detail->account->type_id
                        ];
                        

                        $tlt_dr += $detail->debit;
                        $tlt_cr += $detail->credit;
                    }
                    
                }

                $data['journal'] = [
                    'id' => $journal->id,
                    'code' => $journal->code,
                    'date' => $dt->format('m/d/Y'),
                    'reference' => $journal->reference,
                    'description' => $journal->description,
                    'type' => $journal->type,
                    'tlt_dr' => ($tlt_dr),
                    'tlt_cr' => ($tlt_cr),
                    'details' => $d['details']
                ];
            }

            //dd($data);

            $expense_data = [];
            $bank_data = [];

            $expense_accounts = AccountsChart::whereTypeId('17')->get();
            if(isset($expense_accounts) )
            {
                foreach($expense_accounts as $expense)
                {
                    $expense_data[] = [
                        'id' => $expense['id'],
                        'code' => $expense['code'],
                        'name' => $expense['name']
                    ];
                }
            }


            $bank_accounts = AccountsChart::whereTypeId('9')->get();
            if(isset($bank_accounts) )
            {
                foreach($bank_accounts as $bank)
                {
                    $bank_data[] = [
                        'id' => $bank['id'],
                        'code' => $bank['code'],
                        'name' => $bank['name']
                    ];
                }
            }

            return view('accounting/recieve/edit', ['accounts' => $expense_data, 'journal' => $data['journal'], 'banks' => $bank_accounts]);

            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/payments/received');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function show($id = NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/payments/received');
            
            $data = [];

            $custom = new Customlib();

            $journal = AccountsSummery::where('type', '8')->findOrFail($id);
            if(isset($journal) )
            {
                
                $dt = Carbon::parse($journal->date);

                $d['details'] = [];
                $tlt_dr = 0; $tlt_cr = 0;
                if(isset($journal->details) )
                {
                    foreach($journal->details as $detail)
                    {
                        $qry=AccountsChart::findOrFail($detail->account_id);
                        $name=$qry->name;
 
                        $d['details'][] = [
                            'summery_id' => $detail->summery_id,
                            'account_id' => $detail->account_id,
                            'name'=> $name,
                            'date' => $this->custom->dateformat($detail->date),
                            'debit' => $this->custom->currenyFormat($detail->debit),
                            'credit' => $this->custom->currenyFormat($detail->credit),
                            'description' => $detail->description
                        ];

                        $tlt_dr += $detail->debit;
                        $tlt_cr += $detail->credit;
                    }
                    
                }

                $data['journal'] = [
                    'id' => $journal->id,
                    'code' => $journal->code,
                    'date' => $dt->format('d M, Y'),
                    'reference' => $journal->reference,
                    'description' => $journal->description,
                    'type' => $journal->type,
                    'tlt_dr' => $this->custom->currenyFormat($tlt_dr),
                    'tlt_cr' => $this->custom->currenyFormat($tlt_cr),
                    'details' => $d['details']
                ];
            }

            $data['business_name'] = $this->custom->getSetting('BUSINESS_NAME');
            $data['business_address'] = $this->custom->getSetting('BUSINESS_ADDRESS');
            $data['business_email'] = $this->custom->getSetting('BUSINESS_EMAIL');
            $data['business_phone'] = $this->custom->getSetting('BUSINESS_PHONE');
            $data['business_mobile'] = $this->custom->getSetting('BUSINESS_MOBILE');
            $data['business_logo_image'] = $this->custom->getSetting('BUSINESS_LOGO_IMAGE');

            $data['business_logo_image'] = Storage::url('app/logo/'.$data['business_logo_image']);
            

            return view('accounting/recieve/view', $data);
            
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/payments/received');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Accounts\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = NULL)
    {
        try {
            
            if(is_null($id)) return redirect('accounting/payments/received');

            $rules = [
                'date' => 'required',
            ];

            $this->validate($request, $rules);

            $journal = AccountsSummery::where('type', '8')->findOrFail($id);



            $date = $request->input('date');
            $nice_date =  Carbon::createFromFormat('m/d/Y', $date)->toDateString();
            $code = $request->input('code');
            $reference = $request->input('reference');
            $create_by = Auth::guard('auth')->user()->id;

            $journal->date = $nice_date;
            $journal->reference = $code;
            $journal->description = $reference;
            $journal->type = '8';
            $journal->save();

            $line_debit = $request->input('line_debit');
            $line_credit = $request->input('line_credit');
            $account_type = $request->input('account_type');
            $line_desc = $request->input('line_desc');

            // print_r($account_type);
            // die();

            $account_type_count = count($account_type);
            if(isset($account_type_count) && $account_type_count > 0)
            {
                AccountsSummeryDetail::whereSummeryId($id)->delete();
                $debit = 0; $credit = 0;
                $detail = [];
                for($i = 0; $i < $account_type_count; $i++)
                {
                    
                    if(isset($account_type[$i]) && $account_type[$i] <> "")
                    {
                        $detail[] = [
                            'summery_id' => $id,
                            'account_id' => $account_type[$i],
                            'date' => $nice_date,
                            'debit' => $line_debit[$i], 
                            'credit' => $line_credit[$i],
                            'description' => $line_desc[$i],
                            'added_by' => $create_by,
                        ];
                    }
                }

                AccountsSummeryDetail::insert($detail);
            }

            $request->session()->flash('msg', 'Payment Voucher updated sucssfully.');
            return redirect('accounting/payments/received/edit/'.$id);

        } catch (ModelNotFoundException $e) {
            return redirect('accounting/payments/received');
        }
    }

   
}
