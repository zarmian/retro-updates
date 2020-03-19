<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Models\Accounts\Sales;
use App\Http\Models\Accounts\SalesDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Accounts\Customers;
use App\Http\Models\Accounts\Items;
use App\Http\Models\Accounts\Destination;
use App\Http\Models\Accounts\Origin;
use App\Http\Models\Accounts\AccountsChart;
use App\Http\Models\Accounts\SalesLedger;
use App\Http\Models\Accounts\AccountsSummery;
use App\Http\Models\Accounts\AccountsSummeryDetail;
use App\Http\Models\Admin\EmailTemplates;
use App\Http\Models\Accounts\Tax;
use App\Libraries\Customlib;
use Carbon\Carbon;
use Validator;
use Storage;
use Auth;
use DB;
use PDF;
use URL;


class SalesController extends Controller
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
            $data['sales'] = [];

            $data['per_page'] = \Request::get('per_page') ?: 12;

            $qry = Sales::query();

            if(\Request::has('invoice_no'))
            {
                $invoice_no = \Request::get('invoice_no');
                $qry->where('invoice_number', 'LIKE', "%$invoice_no%");
            }

            if(\Request::has('customer'))
            {
                $customer_id = \Request::get('customer');
                $qry->whereRaw('md5(`customer_id`) = "'.$customer_id.'"');
            }

            if(\Request::has('status'))
            {
                $status = \Request::get('status');
                $qry->where('paid_status', $status);
            }
            
            $qry->orderBy('id', 'DESC');
            $sales = $qry->paginate($data['per_page']);


            if(isset($sales) )
            {
                foreach($sales as $sale)
                {
                    $data['sales'][] = [
                        'id' => $sale->id,
                        'invoice_number' => $sale->invoice_number,
                        'customer_name' => $sale->customer->first_name .' '.$sale->customer->last_name,
                        'reference' => $sale->reference,
                        'customer_id' => $sale->customer_id,
                        'invoice_date' => $this->custom->dateformat($sale->invoice_date),
                        'due_date' => $this->custom->dateformat($sale->due_date),
                        'sub_total' => $this->custom->currenyFormat($sale->sub_total),
                        'discount' => $this->custom->currenyFormat($sale->discount),
                        'total' => $this->custom->currenyFormat($sale->total),
                        'note' => $sale->note,
                        'paid_status' => $sale->paid_status,
                    ];
                }
            }

            $data['pages'] = $sales->appends(\Input::except('page'))->render();

            $data['customers'] = Customers::get();
            return view('accounting/sales/index', $data);
            
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

            $data['customers'] = Customers::get();
            $data['accounts'] = AccountsChart::where('type_id','=','38')
            ->orWhere('type_id','=','37')
            ->get();
            $data['products'] = Items::get();
            $data['tax'] = Tax::get(); 
            $data['destinations']= Destination::get();
            $data['origins']= Origin::get();
            $custom = new Customlib;
            $data['invoice_number'] = $custom->getInvoiceNumber();
            $data['vat'] = $this->custom->getSetting('VAT_TAX');

            return view('accounting/sales/create', $data);

        } catch (ModelNotFoundException $e) {
            return redirect('accounting/sales');
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
                'customer' => 'required',
                'invoice_number' => 'required|unique:tbl_sales',
                'invoice_date' => 'required',
                'due_date' => 'required',
            ]);

            $invoice_date =  Carbon::createFromFormat('m/d/Y', $request->input('invoice_date'))->toDateString();
            $due_date =  Carbon::createFromFormat('m/d/Y', $request->input('due_date'))->toDateString();
            $invoice_number = $request->input('invoice_number');
            $vat_tax_id = $request->input('vat_tax_id');
            $create_by = Auth::guard('auth')->user()->id;


            $vat_tax_amount = 0;

          /*  if($vat_tax_id <> 1){

                $row = Tax::where('id', $vat_tax_id)->first();

                if(isset($row)){
                    $price_from_dis = $request->input('sub_total') - $request->input('discount');
                    $vat_ratio = $price_from_dis / 100;
                    $vat_tax_amount = $vat_ratio * $row->rate;
                }


            }
            else{
                $vat_tax_amount = 0;
            }*/
            

            //$total_amount = $request->input('sub_total') + $vat_tax_amount - $request->input('discount');
            $total_amount = 0;

            $sale = new Sales;
            $sale->invoice_number = $invoice_number;
            $sale->reference = $request->input('reference');
            $sale->customer_id = $request->input('customer');
            $sale->invoice_date = $invoice_date;
            $sale->due_date = $due_date;
            $sale->sub_total = $this->custom->intCurrency($request->input('sub_total'));


            $unitAmount = $request->input('line_unit_price');
            $discount = $request->input('discount');

//            $sale->discount = $this->custom->intCurrency($request->input('discount'));
            $sale->discount = $this->custom->intCurrency($unitAmount[0] * $discount);
            
            $sale->total = $this->custom->intCurrency($request->input('total'));
            $sale->vat_tax_id = $vat_tax_id;
            $sale->vat_tax_amount = $vat_tax_amount;
            $sale->note = $request->input('note');
            $sale->status = '0';
            $sale->paid_status = '3';
            $sale->added_by = $create_by;
            $sale->save();


            if(count($request->input('line_qty')) > 0)
            {

                $title = $request->input('title');
                $line_desc = $request->input('line_desc');
                $line_qty = $request->input('line_qty');
                $line_unit_price = $request->input('line_unit_price');
                $line_total = $request->input('line_total');

                $sale_details = [];
                for($i=0; $i < count($line_qty); $i++)
                {
                    $sale_details[] = [
                        'sale_id' => $sale->id,
                        'title' => $title[$i],
//                        'description' => $line_desc[$i],
                        'description' => ($line_unit_price[0] * $sale->discount),
                        'qty' => $line_qty[$i],
                        'unit_price' => $this->custom->intCurrency($line_unit_price[$i]),
                        'amount' => $this->custom->intCurrency($line_total[$i]),
                        'destination' => $request->input('destination'),
                        'origin' => $request->input('origin')
                    ];
                }



                $sumQuantity = DB::table('tbl_sales_detail')->where('title', $title[0])->sum('qty');


                $currentQuantity = DB::table('tbl_products')->select('price')->where('id', $title[0])->first();
                if($sumQuantity == 0)
                {
                    $temp = $currentQuantity->price - $line_qty[0];
                    DB::table('tbl_products')->where('id', $title[0])->update(['price' => $temp]);
                    DB::table('tbl_sales_detail')->insert($sale_details);
                    $request->session()->flash('msg', __('admin/entries.sales_added'));
                    return redirect('accounting/sales/add');
                }
                elseif($sumQuantity != 0)
                {
                    if($line_qty[0] <= $currentQuantity->price) {
                        $temp = ($currentQuantity->price - $line_qty[0]);
                        DB::table('tbl_products')->where('id', $title[0])->update(['price' => $temp]);
                        DB::table('tbl_sales_detail')->insert($sale_details);
                        $request->session()->flash('msg', __('admin/entries.sales_added'));
                        return redirect('accounting/sales/add');
                    }
                    else{
                        $request->session()->flash('msg', __('admin/entries.quantity_less'));
                        return redirect('accounting/sales/add');
                }

                }






            }





            /*$enable_email = $this->custom->getSetting('ENABLE_EMAIL');
            if(isset($enable_email) && $enable_email == 'true')
            {
                $template = $this->custom->getTemplate(2);

                if(isset($template['status']) && $template['status'] == 1)
                {
                    $customer_id = $request->input('customer');
                    $customer = Customers::find($customer_id);

                    if (starts_with(\Request::root(), 'http://'))
                    {
                        $domain = substr (\Request::root(), 7); // $domain is now 'www.example.com'
                    }

                  
                    $invoice_url = 'www.'.$domain.'/view/sales/invoice/'.($invoice_number);

                    //$invoice_url = url('view/sales/invoice/'.($invoice_number));

                    $var = array('{invoice_url}', '{invoice_id}', '{invoice_amount}', '{invoice_due_date}', '{business_name}');

                    $val = array($invoice_url, $invoice_number, $request->input('total'), $due_date, $this->custom->getSetting('BUSINESS_NAME'));

                    $template_cotent = str_replace($var, $val, $template['content']);
                    
                    $template = $this->custom->basic_email($customer->email, $template['subject'], $template_cotent);
                }

            }
            
            $request->session()->flash('msg', __('admin/entries.sales_added'));
            return redirect('accounting/sales/add');*/
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/sales');
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

            if(is_null($id)) return redirect('accounting/sales');
           
            $sale = Sales::findOrFail($id);

            if(isset($sale) )
            {

                $details = [];
                $p = [];
                
                if(isset($sale->details) )
                {
                    foreach($sale->details as $detail)
                    {

                        $row = Items::where('id', $detail->title)->first();
                        
                        $details[] =  [
                            'id' => $detail->id,
                            'sale_id' => $detail->sale_id,
                            'title' => $row->name,
                            'description' => $detail->description,
                            'qty' => $detail->qty,
                            'unit_price' => $this->custom->currenyFormat($detail->unit_price),
                            'amount' => $this->custom->currenyFormat($detail->amount),
                        ];
                    }
                }

                $tlt_paid_sum = 0;
                if(isset($sale->paid) )
                {
                    
                    foreach($sale->paid as $paid)
                    {
                       
                        $p[] =  [
                            'id' => $paid->id,
                            'sale_id' => $paid->sale_id,
                            'account_id' => $paid->account_id,
                            'account_name' => $paid->account->name,
                            'customer_id' => $paid->customer_id,
                            'payment_no' => $paid->payment_no,
                            'date' => $this->custom->dateformat($paid->date),
                            'references' => $paid->references,
                            'amount' => $this->custom->currenyFormat($paid->amount),
                            'description' => $paid->description,
                            
                        ];

                        $tlt_paid_sum = $tlt_paid_sum + $paid->amount;
                       
                    }
                }


                $data['sale'] = [
                    'id' => $sale->id,
                    'inv_no' => $sale->invoice_number,
                    'inv_date' => $this->custom->dateformat($sale->invoice_date),
                    'due_date' => $this->custom->dateformat($sale->due_date),
                    'paid_status' => $sale->paid_status,
                    'reference' => $sale->reference,
                    'discount' => $this->custom->currenyFormat($sale['discount']),
                    'customer' => $sale->customer,
                    'payments' => $p,
                    'details' => $details,
                    'vat_tax_id' => $sale->vat_tax_id,
                    'vat_tax_amount' => $this->custom->currenyFormat($sale->vat_tax_amount),
                    'unit_price' => $this->custom->currenyFormat($sale['sub_total']),
                    'total' => $this->custom->currenyFormat($sale['sub_total'] + $sale->vat_tax_amount - $sale['discount']),
                    'tlt_paid_sum' => $this->custom->currenyFormat($tlt_paid_sum),
                    'due_amount' => $this->custom->currenyFormat($sale['sub_total'] + $sale->vat_tax_amount - $sale['discount'] - $tlt_paid_sum),
                    'note' => $sale->note
                ];

                
                $data['business_name'] = $this->custom->getSetting('BUSINESS_NAME');
                $data['business_address'] = $this->custom->getSetting('BUSINESS_ADDRESS');
                $data['business_email'] = $this->custom->getSetting('BUSINESS_EMAIL');
                $data['business_phone'] = $this->custom->getSetting('BUSINESS_PHONE');
                $data['business_mobile'] = $this->custom->getSetting('BUSINESS_MOBILE');
                $data['business_logo_image'] = $this->custom->getSetting('BUSINESS_LOGO_IMAGE');

                $data['business_logo_image'] = Storage::url('app/logo/'.$data['business_logo_image']);
             
            }


            return view('accounting/sales/view', $data);
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/sales');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function payment_modal($id = NULL)
    {
        try {

            if(is_null($id)) return view('accounting.sales.notfound');

            $sale = Sales::findOrFail($id);

            $data['sale'] = [
                'id' => $sale->id,
                'customer_id' => $sale->customer_id,
                'inv_no' => $sale->invoice_number,
                'customer_name' => $sale->customer->first_name .' '.$sale->customer->last_name, 
                'sub_total' => $this->custom->currenyFormat($sale->sub_total),
                'discount' => $this->custom->currenyFormat($sale->discount),
                'total' => $this->custom->currenyFormat($sale->total - $sale->discount),
                'tlt_amt' => $sale->sub_total + $sale->vat_tax_amount - $sale->discount - $sale->paid->sum('amount'),
                'paid' => $sale->paid->sum('amount'),
            ];

            //print_r($data);

            $data['accounts'] = AccountsChart::where('type_id','=','38')
            ->orWhere('type_id','=','37')
            ->get();

            
            $data['payment_number'] = $this->custom->getPaymentNumber();

            return view('accounting.sales.modal', $data);
            
        } catch (ModelNotFoundException $e) {
            return view('accounting.sales.notfound');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function ajax(Request $request)
    {

        try {

            if($request->ajax()){

                $validator = Validator::make($request->all(), [
                    'customer_id' => 'required',
                    'sale_id' => 'required',
                    'payment_no' => 'required|unique:tbl_sales_ledger',
                    'account_id' => 'required',
                    'pay_amount' => 'required|between:0,99.99'
                ]);

                if ($validator->passes()) {

                    $sale = Sales::findOrFail($request->input('sale_id'));

                    $date = Carbon::createFromFormat('m/d/Y', $request->input('pdate'))->toDateString();

                    $create_by = Auth::guard('auth')->user()->id;

                    $tlt_paid = $sale->paid->sum('amount');
                    $tlt_amount = $sale->sub_total - $sale->discount;

                    $customer_id = $request->input('customer_id');
                    
                    if(($tlt_amount - $tlt_paid) <> 0 ){

                        $customer = Customers::leftJoin('tbl_accounts_chart', 'tbl_customers.code', '=', 'tbl_accounts_chart.code')->select(DB::raw('tbl_customers.id as vid, tbl_accounts_chart.id as cid'))->where('tbl_customers.id', $customer_id)->first();

                        if(isset($customer) )
                        {

                            $ledger = new SalesLedger;
                            $ledger->sale_id = $request->input('sale_id');
                            $ledger->account_id = $request->input('account_id');
                            $ledger->customer_id = $customer_id;
                            $ledger->payment_no = $request->input('payment_no');
                            $ledger->date = $date;
                            $ledger->references = $request->input('reference');
                            $ledger->amount = $request->input('pay_amount');
                            $ledger->description = $request->input('description');
                            $ledger->added_by = $create_by;
                            $ledger->save();

                            if($ledger)
                            {
                                $summery = new AccountsSummery();
                                $summery->date = $date;
                                $summery->code = $request->input('payment_no');
                                $summery->reference  = $request->input('reference');
                                $summery->description = $request->input('description');
                                $summery->type = '2';
                                $summery->added_by = $create_by;
                                $summery->save();

                                if($summery)
                                {
                                    // Debit Amount Enter
                                    $sdetail_dr = new AccountsSummeryDetail();

                                    $sdetail_dr->summery_id = $summery->id;
                                    $sdetail_dr->account_id = $customer->cid;
                                    $sdetail_dr->date = $date;
                                    $sdetail_dr->debit = $request->input('pay_amount');
                                    $sdetail_dr->credit = '0';
                                    $sdetail_dr->description = $request->input('description');
                                    $sdetail_dr->added_by = $create_by;
                                    $sdetail_dr->save();

                                    // Credit Amount Enter
                                    $sdetail_cr = new AccountsSummeryDetail();

                                    $sdetail_cr->summery_id = $summery->id;
                                    $sdetail_cr->account_id = $request->input('account_id');
                                    $sdetail_cr->date = $date;
                                    $sdetail_cr->debit = '0';
                                    $sdetail_cr->credit = $request->input('pay_amount');
                                    $sdetail_cr->description = $request->input('description');
                                    $sdetail_cr->added_by = $create_by;
                                    $sdetail_cr->save();

                                }

                            }

                            $u_sale = Sales::findOrFail($sale->id);

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

                            return response()->json(['success'=> $sale, 'status' => $tlt_paid_sum]);
                        }

                        return response()->json(['error'=> 'Invalid', 'status' => '']);


                    }

                }


                return response()->json(['error'=>$validator->errors()->all()]);
            }
            
        } catch (ModelNotFoundException $e) {
            return response()->json(['error'=> 'Invalid']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function edit($id = NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/sales');

            $data = [];

            $data['customers'] = Customers::get();
            $data['accounts'] = AccountsChart::where('type_id','=','38')
            ->orWhere('type_id','=','37')
            ->get();

            $sale = Sales::findOrFail($id);

            $details = [];
            if(isset($sale->details) )
            {
                foreach($sale->details as $detail)
                {
                    
                    $details[] = [
                        'id' => $detail->id,
                        'sale_id' => $detail->sale_id,
                        'title' => $detail->title,
                        'description' => $detail->description,
                        'qty' => $detail->qty,
                        'unit_price' => $detail->unit_price,
                        'amount' => $detail->amount,
                    ];
                }
            }
                
            $data['sale'] = [
                'id' => $sale->id,
                'invoice_number' => $sale->invoice_number,
                'customer_name' => $sale->customer->first_name .' '.$sale->customer->last_name,
                'reference' => $sale->reference,
                'vat_tax_id' => $sale->vat_tax_id,
                'customer_id' => $sale->customer_id,
                'invoice_date' => date('m/d/Y', strtotime($sale->invoice_date)),
                'due_date' => date('m/d/Y', strtotime($sale->due_date)),
                'sub_total' => number_format($sale->sub_total, 2),
                'discount' => number_format($sale->discount, 2),
                'total' => number_format($sale->total, 2),
                'note' => $sale->note,
                'details' => $details
            ];

            $data['products'] = Items::get();
            $data['tax'] = Tax::get(); 

            return view('accounting/sales/edit', $data);
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/sales');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Accounts\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/sales');

            $this->validate($request, [
                'customer' => 'required',
                'invoice_date' => 'required',
                'due_date' => 'required',
            ]);

            
            $invoice_date =  Carbon::createFromFormat('m/d/Y', $request->input('invoice_date'))->toDateString();
            $due_date =  Carbon::createFromFormat('m/d/Y', $request->input('due_date'))->toDateString();
            $invoice_number = $this->custom->getInteger($request->input('invoice_number'));
            $create_by = Auth::guard('auth')->user()->id;

            $vat_tax_id = $request->input('vat_tax_id');


            $sale = Sales::findOrFail($id);


            $vat_tax_amount = 0;

            if($vat_tax_id <> 1){

                $row = Tax::where('id', $vat_tax_id)->first();

                if(isset($row)){
                    $price_from_dis = $request->input('sub_total') - $request->input('discount');
                    $vat_ratio = $price_from_dis / 100;
                    $vat_tax_amount = $vat_ratio * $row->rate;
                }
            }else{
                $vat_tax_amount = 0;
            }

            $total_amount = $request->input('sub_total') + $vat_tax_amount - $request->input('discount');

            $sale->reference = $request->input('reference');
            $sale->customer_id = $request->input('customer');
            $sale->invoice_date = $invoice_date;
            $sale->due_date = $due_date;
            $sale->vat_tax_id = $vat_tax_id;
            $sale->vat_tax_amount = $vat_tax_amount;
            $sale->sub_total = $this->custom->intCurrency($request->input('sub_total'));
            $sale->discount = $this->custom->intCurrency($request->input('discount'));
            $sale->total = $this->custom->intCurrency($total_amount);
            $sale->note = $request->input('note');
            $sale->added_by = $create_by;
            $sale->save();


            if(count($request->input('title')) > 0)
            {

                SalesDetail::whereSaleId($id)->delete();

                $title = $request->input('title');
                $line_desc = $request->input('line_desc');
                $line_qty = $request->input('line_qty');
                $line_unit_price = $request->input('line_unit_price');
                $line_total = $request->input('line_total');

                $sale_details = [];
                for($i=0; $i < count($title); $i++)
                {

                    if(isset($title[$i]) && !empty($title[$i]) && isset($line_unit_price[$i]) && !empty($line_unit_price[$i]) )
                    {
                        $sale_details[] = [
                            'sale_id' => $sale->id,
                            'title' => $title[$i],
                            'description' => $line_desc[$i],
                            'qty' => $line_qty[$i],
                            'unit_price' => $this->custom->intCurrency($line_unit_price[$i]),
                            'amount' => $this->custom->intCurrency($line_total[$i])
                        ];
                    }
                    
                }

                DB::table('tbl_sales_detail')->insert($sale_details);
            }


            $request->session()->flash('msg', __('admin/entries.sales_update'));
            return redirect('accounting/sales/edit/'.$id);
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/sales');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Models\Accounts\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function destroy($id = NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/sales');

            $sale = Sales::findOrFail($id);
            $delete = $sale->delete();
            if($sale)
            {
                \Request::session()->flash('msg', __('admin/entries.delete_msg'));
            }

            return redirect('accounting/sales');

        } catch (ModelNotFoundException $e) {
             return redirect('accounting/sales');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function invoice_modal($id = NULL, $type = NULL)
    {
        try {

            if(is_null($id)) return view('accounting.sales.notfound');

            $sale = Sales::findOrFail($id);

            $data = [];
            $data['title'] = '';

            if($type == 'created'){
                $data['title'] = 'Create New Invoice';
                $data['template_id'] = 2;
            }elseif($type == 'reminder'){
                $data['title'] = 'Create Payment Reminder';
                $data['template_id'] = 4;
            }elseif($type == 'overdue'){
                $data['title'] = 'Invoice Overdue Notice';
                $data['template_id'] = 3;
            }elseif($type == 'confirmation'){
                $data['title'] = 'Invoice Payment Confirmation';
                $data['template_id'] = 5;
            }elseif($type == 'refund'){
                $data['title'] = 'Invoice Refund Confirmtion';
                $data['template_id'] = 6;
            }


            $template = EmailTemplates::findOrFail($data['template_id']);

            $content =  Storage::get('templates/'.$template->file_name);
            
            $content2 = Storage::disk('local')->get('templates/'.$template->file_name);

            $data['template'] = [
                'id' => $template->id,
                'title' => $template->title,
                'subject' => $template->subject,
                'status' => $template->status,
                'file_name' => $template->file_name,
                'body' => $content,
                'body2' => $content2,
                'variables' => $template->variables,
                'email_to' => $sale->customer->email,
                'sale_id' => $sale->id,
                'invoice_number' => $sale->invoice_number,
            ];


            return view('accounting.sales.mail', $data);
            
        } catch (ModelNotFoundException $e) {
            return view('accounting.sales.notfound');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        try {

            if($request->ajax()){

                $validator = Validator::make($request->all(), [
                    'sale_id' => 'required',
                    'mail_to' => 'required|email'
                ]);

                if ($validator->passes()) {

                    $id = $request->input('sale_id');
                    $mail_to = $request->input('mail_to');
                    $cc = $request->input('mail_cc');
                    $bcc = $request->input('mail_bcc');
                    $subject = $request->input('subject');
                    $description = $request->input('description');
                    $attach_pdf = $request->input('attach_pdf');

                    $sale = Sales::findOrFail($id);

                    
                    $enable_email = $this->custom->getSetting('ENABLE_EMAIL');
                    if(isset($enable_email) && $enable_email == 'true')
                    {
                     
                        $customer = Customers::find($sale->customer_id);
                        $invoice_number = $sale->invoice_number;
                        $total = $this->custom->currenyFormat($sale->sub_total - $sale->discount);
                        $due_date = $this->custom->dateformat($sale->due_date);
                        $invoice_date = $this->custom->dateformat($sale->invoice_date);
                        $attachment = '';

                        //$invoice_url = url('view/sales/invoice/'.($invoice_number));

                        if (starts_with(\Request::root(), 'http://'))
                        {
                            $domain = substr (\Request::root(), 7); // $domain is now 'www.example.com'
                        }
                      
                        $invoice_url = 'www.'.$domain.'/view/sales/invoice/'.($invoice_number);

                        $var = array('{invoice_url}', '{invoice_date}', '{invoice_id}', '{invoice_amount}', '{invoice_due_date}', '{business_name}');

                        $val = array($invoice_url, $invoice_date, $invoice_number, $total, $due_date, $this->custom->getSetting('BUSINESS_NAME'));

                        $template_cotent = str_replace($var, $val, $description);

                        if(isset($attach_pdf) && $attach_pdf <> "" && $attach_pdf == "Yes")
                        {


                            $data['business_name'] = $this->custom->getSetting('BUSINESS_NAME');
                            $data['business_address'] = $this->custom->getSetting('BUSINESS_ADDRESS');
                            $data['business_email'] = $this->custom->getSetting('BUSINESS_EMAIL');
                            $data['business_phone'] = $this->custom->getSetting('BUSINESS_PHONE');
                            $data['business_mobile'] = $this->custom->getSetting('BUSINESS_MOBILE');
                            $data['business_logo_image'] = $this->custom->getSetting('BUSINESS_LOGO_IMAGE');

                            $data['business_logo_image'] = Storage::url('app/logo/'.$data['business_logo_image']);


                            $details = [];
                            $p = [];
                            
                            if(isset($sale->details) )
                            {
                                foreach($sale->details as $detail)
                                {
                                    
                                    $details[] =  [
                                        'id' => $detail->id,
                                        'sale_id' => $detail->sale_id,
                                        'title' => $detail->title,
                                        'description' => $detail->description,
                                        'qty' => $detail->qty,
                                        'unit_price' => $this->custom->currenyFormat($detail->unit_price),
                                        'amount' => $this->custom->currenyFormat($detail->amount),
                                    ];
                                }
                            }


                            if(isset($sale->paid) )
                            {
                                $tlt_paid_sum = 0;
                                foreach($sale->paid as $paid)
                                {
                                   
                                    $p[] =  [
                                        'id' => $paid->id,
                                        'sale_id' => $paid->sale_id,
                                        'account_id' => $paid->account_id,
                                        'customer_id' => $paid->customer_id,
                                        'payment_no' => $paid->payment_no,
                                        'date' => $paid->date,
                                        'references' => $paid->references,
                                        'amount' => $this->custom->currenyFormat($paid->amount),
                                        'description' => $paid->description,
                                        
                                    ];

                                    $tlt_paid_sum = $tlt_paid_sum + $paid->amount;
                                   
                                }
                            }


                            $data['sale'] = [
                                'id' => $sale->id,
                                'inv_no' => $sale->invoice_number,
                                'inv_date' => $this->custom->dateformat($sale->invoice_date),
                                'due_date' => $this->custom->dateformat($sale->due_date),
                                'paid_status' => $sale->paid_status,
                                'discount' => $this->custom->currenyFormat($sale['discount']),
                                'customer' => $sale->customer,
                                'payments' => $p,
                                'details' => $details,
                                'unit_price' => $this->custom->currenyFormat($sale['sub_total']),
                                'total' => $this->custom->currenyFormat($sale['sub_total'] - $sale['discount']),
                                'tlt_paid_sum' => $this->custom->currenyFormat($tlt_paid_sum),
                                'due_amount' => $this->custom->currenyFormat($sale['sub_total'] - $sale['discount'] - $tlt_paid_sum)
                            ];

                       

                            $pdf = PDF::loadView('accounting/sales/pdf', $data, [], array(
                                'default_font' => 'Arial',
                                'title' => 'mPDF',
                                'display_mode' => 'fullpage',
                                'default_font' => 'helvetica',
                            ));

                            $pdf->save(storage_path('app/invoices/'.$sale->invoice_number.'.pdf'));

                            $attachment = storage_path('app/invoices/'.$sale->invoice_number.'.pdf');
                        }
 
                        $template = $this->custom->mail($mail_to, $cc, $bcc, $subject, $template_cotent, $attachment);

                        return response()->json(['success'=> $template_cotent]);
                    }else{
                        return response()->json(['error'=> ['Sorry! Email has been disabled, please check your setting.']]);
                    }

                    

                }
                
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            
        } catch (ModelNotFoundException $e) {
            return view('accounting.sales.notfound');
        }
    }

    public function show_invoice($inv_no = NULL)
    {
        try {
            
            if(is_null($inv_no)) return view('accounting.sales.notfound');

            $data = [];
            $sale = Sales::where('invoice_number', $inv_no)->first();
            
            if(isset($sale) )
            {

                $payments = [];
                if(isset($sale->paid) )
                {
                    $total = $sale->total - $sale->discount;
                    $balance = $sale->total - $sale->discount;
                    foreach($sale->paid as $payment)
                    {
                        $balance = $balance - $payment->amount;
                        
                        $payments[] = [
                            'payment_no' => $payment->payment_no,
                            'date' => $this->custom->dateformat($payment->date),
                            'references' => $payment->references,
                            'amount' => $this->custom->currenyFormat($payment->amount),
                            'description' => $payment->description,
                            'total' => $this->custom->currenyFormat($total),
                            'balance' => $this->custom->currenyFormat($balance)
                        ];
                        $total = $total - $payment->amount;
                    }
                    
                }

               
                $data['business_name'] = $this->custom->getSetting('BUSINESS_NAME');
                $data['business_address'] = $this->custom->getSetting('BUSINESS_ADDRESS');
                $data['business_email'] = $this->custom->getSetting('BUSINESS_EMAIL');
                $data['business_phone'] = $this->custom->getSetting('BUSINESS_PHONE');
                $data['business_mobile'] = $this->custom->getSetting('BUSINESS_MOBILE');
                $data['business_logo_image'] = $this->custom->getSetting('BUSINESS_LOGO_IMAGE');

                $data['business_logo_image'] = Storage::url('app/logo/'.$data['business_logo_image']);

                $details = [];
                $p = [];
                
                if(isset($sale->details))
                {
                    foreach($sale->details as $detail)
                    {
                        
                        $details[] =  [
                            'id' => $detail->id,
                            'sale_id' => $detail->sale_id,
                            'title' => $detail->title,
                            'description' => $detail->description,
                            'qty' => $detail->qty,
                            'unit_price' => $this->custom->currenyFormat($detail->unit_price),
                            'amount' => $this->custom->currenyFormat($detail->amount),
                        ];
                    }
                }

                $tlt_paid_sum = 0;
                if(isset($sale->paid) )
                {
                    
                    foreach($sale->paid as $paid)
                    {
                       
                        $p[] =  [
                            'id' => $paid->id,
                            'sale_id' => $paid->sale_id,
                            'account_id' => $paid->account_id,
                            'customer_id' => $paid->customer_id,
                            'payment_no' => $paid->payment_no,
                            'date' => $this->custom->dateformat($paid->date),
                            'references' => $paid->references,
                            'amount' => $this->custom->currenyFormat($paid->amount),
                            'description' => $paid->description,
                            
                        ];

                        $tlt_paid_sum = $tlt_paid_sum + $paid->amount;
                       
                    }
                }


                $data['sale'] = [
                    'id' => $sale->id,
                    'inv_no' => $sale->invoice_number,
                    'inv_date' => $this->custom->dateformat($sale->invoice_date),
                    'due_date' => $this->custom->dateformat($sale->due_date),
                    'paid_status' => $sale->paid_status,
                    'discount' => $this->custom->currenyFormat($sale['discount']),
                    'customer' => $sale->customer,
                    'payments' => $p,
                    'details' => $details,
                    'unit_price' => $this->custom->currenyFormat($sale['sub_total']),
                    'total' => $this->custom->currenyFormat($sale['sub_total'] - $sale['discount']),
                    'tlt_paid_sum' => $this->custom->currenyFormat($tlt_paid_sum),
                    'due_amount' => $this->custom->currenyFormat($sale['sub_total'] - $sale['discount'] - $tlt_paid_sum)
                ];
            }

            return view('accounting/sales/invoice', $data);

        } catch (ModelNotFoundException $e) {
            return view('accounting.sales.notfound');
        }
    }



    public function vat_price(Request $request){
        try {

            $id = $request->input('id');
            if($id <> ""){

                $row = Tax::findOrFail($id);
                return response()->json(['error'=> '0', 'row' => $row]);

            }else{
                return response()->json(['error'=> '1', 'row' => 'Sorry! Email has been disabled, please check your setting.']);
            }
            
        } catch (ModelNotFoundException $e) {
            
        }
    }
}