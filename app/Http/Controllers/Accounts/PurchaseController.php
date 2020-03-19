<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Accounts\AccountsSummeryDetail;
use App\Http\Models\Accounts\AccountsSummery;
use App\Http\Models\Accounts\PurchaseDetail;
use App\Http\Models\Accounts\PurchaseLedger;
use App\Http\Models\Accounts\AccountsChart;
use App\Http\Models\Admin\EmailTemplates;
use App\Http\Models\Accounts\Purchase;
use App\Http\Models\Accounts\Vendors;
use App\Http\Controllers\Controller;
use App\Http\Models\Accounts\Items;
use App\Http\Models\Accounts\Destination;
use App\Http\Models\Accounts\Origin;
use Illuminate\Http\Request;
use App\Libraries\Customlib;
use Carbon\Carbon;
use Validator;
use Storage;
use Auth;
use DB;
use PDF;
use URL;


class PurchaseController extends Controller
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

            $qry = Purchase::query();

            if(\Request::has('invoice_no'))
            {
                $invoice_no = \Request::get('invoice_no');
                $qry->where('invoice_number', 'LIKE', "%$invoice_no%");
            }

            if(\Request::has('v'))
            {
                $vendor_id = \Request::get('v');
                $qry->whereRaw('md5(`vendor_id`) = "'.$vendor_id.'"');
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
                        'customer_name' => $sale->vendor->first_name .' '.$sale->vendor->last_name,
                        'reference' => $sale->reference,
                        'customer_id' => $sale->vendor_id,
                        'invoice_date' => $this->custom->dateformat($sale->invoice_date),
                        'due_date' => $this->custom->dateformat($sale->due_date),
                        'sub_total' => number_format($sale->sub_total, 2),
                        'discount' => number_format($sale->discount, 2),
                        'total' => number_format($sale->total, 2),
                        'note' => $sale->note,
                        'paid_status' => $sale->paid_status,
                    ];
                }
            }

            $data['pages'] = $sales->appends(\Input::except('page'))->render();

            $data['currency'] = $this->custom->currencyFormatSymbol();
            $data['customers'] = Vendors::get();

            return view('accounting/purchase/index', $data);
            
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

            $data['customers'] = Vendors::get();
            $data['accounts'] = AccountsChart::where('type_id','=','38')
            ->orWhere('type_id','=','37')
            ->get();
            $data['products'] = Items::get();
            $data['destinations']= Destination::get();
            $data['origins']= Origin::get();

            $data['invoice_number'] = $this->custom->getVoucherNumber();

            return view('accounting/purchase/create', $data);

        } catch (ModelNotFoundException $e) {
            return redirect('accounting/purchase');
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
                'vendor' => 'required',
                'invoice_number' => 'required|unique:tbl_purchase',
                'invoice_date' => 'required',
                'due_date' => 'required',
            ]);

          
            $invoice_date =  Carbon::createFromFormat('m/d/Y', $request->input('invoice_date'))->toDateString();
            $due_date =  Carbon::createFromFormat('m/d/Y', $request->input('due_date'))->toDateString();
            $invoice_number = $request->input('invoice_number');
            $create_by = Auth::guard('auth')->user()->id;

            $sale = new Purchase;
            $sale->invoice_number = $invoice_number;
            $sale->reference = $request->input('reference');
            $sale->vendor_id = $request->input('vendor');
            $sale->invoice_date = $invoice_date;
            $sale->due_date = $due_date;
            $sale->sub_total = $this->custom->intCurrency($request->input('sub_total'));

            $unitAmount = $request->input('line_unit_price');
            $discount = $request->input('discount');
            //$this->custom->intCurrency($request->input('discount'))
            $sale->discount = $this->custom->intCurrency($unitAmount[0] * $discount);
            $sale->total = $this->custom->intCurrency($request->input('total'));
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

                print_r($line_unit_price[0] * $sale->discount);
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
                        'amount' => $this->custom->intCurrency($line_total[$i])
                    ];
                }



                DB::table('tbl_purchase_detail')->insert($sale_details);
                $updateQuantity = DB::table('tbl_purchase_detail')->where('title', $title[0])->sum('qty');
                $currentQuantity = DB::table('tbl_products')->select('price')->where('id', $title[0])->first();
                $temp = $updateQuantity + $currentQuantity->price;
                DB::table('tbl_products')->where('id', $title[0])->update(['price' => $temp]);
            }

            $request->session()->flash('msg', __('admin/entries.sales_added'));
            return redirect('accounting/purchase/add');
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/purchase');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show($id=NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/purchase');
           
            $sale = Purchase::findOrFail($id);

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


                $payments = [];
                if(isset($sale->paid) )
                {
                    $total = $sale->total - $sale->discount;
                    $balance = $sale->total - $sale->discount;
                    foreach($sale->paid as $payment)
                    {
                        $row = Items::where('id', $payment->title)->first();

                        $balance = $balance - $payment->amount;
                        
                        $payments[] = [
                            'payment_no' => $payment->payment_no,
                            'date' => $this->custom->dateformat($payment->date),
                            'references' => $payment->references,
                            'amount' => number_format($payment->amount, 2),
                            // 'description' => $row->name,
                            'total' => number_format($total, 2),
                            'balance' => number_format($balance, 2)
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
                
                
                $data['sale'] = [
                    'id' => $sale->id,
                    'inv_no' => $sale->invoice_number,
                    'reference' => $sale->reference,
                    'inv_date' => $this->custom->dateformat($sale->invoice_date),
                    'due_date' => $this->custom->dateformat($sale->due_date),
                    'paid_status' => $sale->paid_status,
                    'discount' => $sale->discount,
                    'customer' => $sale->vendor,
                    'payments' => $sale->paid,
                    'details' => $details,
                    'details2' => $sale->details,
                    'note' => $sale->note,
                ];
            }

            $data['currency'] = $this->custom->currencyFormatSymbol();

            return view('accounting/purchase/view', $data);
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/purchase');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit($id = NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/purchase');

            $data = [];

            $data['customers'] = Vendors::get();
            $data['accounts'] = AccountsChart::where('type_id','=','38')
            ->orWhere('type_id','=','37')
            ->get();

            $sale = Purchase::findOrFail($id);
                
            $data['sale'] = [
                'id' => $sale->id,
                'invoice_number' => $sale->invoice_number,
                'customer_name' => $sale->vendor->first_name .' '.$sale->vendor->last_name,
                'reference' => $sale->reference,
                'customer_id' => $sale->vendor_id,
                'invoice_date' => date('m/d/Y', strtotime($sale->invoice_date)),
                'due_date' => date('m/d/Y', strtotime($sale->due_date)),
                'sub_total' => number_format($sale->sub_total, 2),
                'discount' => number_format($sale->discount, 2),
                'total' => number_format($sale->total, 2),
                'note' => $sale->note,
                'details' => $sale->details
            ];

            $data['products'] = Items::get();

            return view('accounting/purchase/edit', $data);
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/purchase');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Accounts\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = NULL)
    {
        try {
            
            if(is_null($id)) return redirect('accounting/purchase');

            $this->validate($request, [
                'vendor' => 'required',
                'invoice_date' => 'required',
                'due_date' => 'required',
            ]);

            $purchase = Purchase::findOrFail($id);

            $invoice_date =  Carbon::createFromFormat('m/d/Y', $request->input('invoice_date'))->toDateString();
            $due_date =  Carbon::createFromFormat('m/d/Y', $request->input('due_date'))->toDateString();
            $invoice_number = $request->input('invoice_number');
            $create_by = Auth::guard('auth')->user()->id;

            
            $purchase->reference = $request->input('reference');
            $purchase->vendor_id = $request->input('vendor');
            $purchase->invoice_date = $invoice_date;
            $purchase->due_date = $due_date;
            $purchase->sub_total = $this->custom->intCurrency($request->input('sub_total'));
            $purchase->discount = $this->custom->intCurrency($request->input('discount'));
            $purchase->total = $this->custom->intCurrency($request->input('total'));
            $purchase->note = $request->input('note');
            $purchase->added_by = $create_by;
            $purchase->save();


            if(count($request->input('line_qty')) > 0)
            {

                PurchaseDetail::whereSaleId($id)->delete();

                $title = $request->input('title');
                $line_desc = $request->input('line_desc');
                $line_qty = $request->input('line_qty');
                $line_unit_price = $request->input('line_unit_price');
                $line_total = $request->input('line_total');

                $sale_details = [];
                for($i=0; $i < count($line_qty); $i++)
                {


                    if(isset($title[$i]) && $title[$i] <> "")
                    {
                        $sale_details[] = [
                            'sale_id' => $id,
                            'title' => $title[$i],
                            'description' => $line_desc[$i],
                            'qty' => $line_qty[$i],
                            'unit_price' => $this->custom->intCurrency($line_unit_price[$i]),
                            'amount' => $this->custom->intCurrency($line_total[$i])
                        ];
                    }
                    
                }

                DB::table('tbl_purchase_detail')->insert($sale_details);
            }

            
            $request->session()->flash('msg', __('admin/entries.purchase_updated'));
            return redirect('accounting/purchase/edit/'.$id);


        } catch (ModelNotFoundException $e) {
            return redirect('accounting/purchase');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */

    public function payment_modal($id = NULL)
    {
        try {

            if(is_null($id)) return view('accounting.sales.notfound');

            $sale = Purchase::findOrFail($id);

            $data['sale'] = [
                'id' => $sale->id,
                'customer_id' => $sale->vendor_id,
                'inv_no' => $sale->invoice_number,
                'customer_name' => $sale->vendor->first_name .' '.$sale->vendor->last_name, 
                'sub_total' => number_format($sale->sub_total, 2),
                'discount' => number_format($sale->discount, 2),
                'total' => number_format($sale->total - $sale->discount, 2),
                'tlt_amt' => $sale->sub_total - $sale->discount - $sale->paid->sum('amount'),
                'paid' => $sale->paid->sum('amount'),
            ];

            $data['accounts'] = AccountsChart::where('type_id','=','38')
            ->orWhere('type_id','=','37')
            ->get();

            
            $data['payment_number'] = $this->custom->getVoucherPaymentNumber();

            $data['currency'] = $this->custom->currencyFormatSymbol();

            return view('accounting.purchase.modal', $data);
            
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
                    'payment_no' => 'required|unique:tbl_purchase_ledger',
                    'account_id' => 'required',
                    'pay_amount' => 'required|between:0,99.99'
                ]);

                if ($validator->passes()) {

                    $sale = Purchase::findOrFail($request->input('sale_id'));

                    $date = Carbon::createFromFormat('m/d/Y', $request->input('pdate'))->toDateString();

                    $create_by = Auth::guard('auth')->user()->id;

                    $tlt_paid = $sale->paid->sum('amount');
                    $tlt_amount = $sale->sub_total - $sale->discount;
                    
                    if(($tlt_amount - $tlt_paid) <> 0 ){

                        $customer_id = $request->input('customer_id');

                        $vendor = Vendors::leftJoin('tbl_accounts_chart', 'tbl_vendors.code', '=', 'tbl_accounts_chart.code')->select(DB::raw('tbl_vendors.id as vid, tbl_accounts_chart.id as cid'))->where('tbl_vendors.id', $customer_id)->first();

                    
                        $ledger = new PurchaseLedger;
                        $ledger->sale_id = $request->input('sale_id');
                        $ledger->account_id = $request->input('account_id');
                        $ledger->vendor_id = $customer_id;
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
                                $sdetail_dr->account_id = $vendor->cid;
                                $sdetail_dr->date = $date;
                                $sdetail_dr->debit = '0';
                                $sdetail_dr->credit = $request->input('pay_amount');
                                $sdetail_dr->description = $request->input('description');
                                $sdetail_dr->added_by = $create_by;
                                $sdetail_dr->save();

                                // Credit Amount Enter
                                $sdetail_cr = new AccountsSummeryDetail();

                                $sdetail_cr->summery_id = $summery->id;
                                $sdetail_cr->account_id = $request->input('account_id');
                                $sdetail_cr->date = $date;
                                $sdetail_cr->debit = $request->input('pay_amount');
                                $sdetail_cr->credit = '0';
                                $sdetail_cr->description = $request->input('description');
                                $sdetail_cr->added_by = $create_by;
                                $sdetail_cr->save();
                                if(isset($sale) && ($sale->discount) >0)
                                {
                                    $sdetail_cr = new AccountsSummeryDetail();

                                $sdetail_cr->summery_id = $summery->id;
                                $sdetail_cr->account_id = '12';
                                $sdetail_cr->date = $date;
                                $sdetail_cr->debit = '0';
                                $sdetail_cr->credit = $sale->discount;
                                $sdetail_cr->description = $request->input('description');
                                $sdetail_cr->added_by = $create_by;
                                $sdetail_cr->save();
                                }


                            }

                        }

                        $u_sale = Purchase::findOrFail($sale->id);

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

                }


                return response()->json(['error'=>$validator->errors()->all()]);
            }
            
        } catch (ModelNotFoundException $e) {
            return response()->json(['error'=> 'Invalid']);
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

            if(is_null($id)) return view('accounting.purchase.notfound');

            $sale = Purchase::findOrFail($id);

            $data = [];
            $data['title'] = '';

            if($type == 'created'){
                $data['title'] = 'Create New Invoice';
                $data['template_id'] = 7;
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
                'email_to' => $sale->vendor->email,
                'sale_id' => $sale->id,
                'invoice_number' => $sale->invoice_number,
            ];

            $data['currency'] = $this->custom->currencyFormatSymbol();

            return view('accounting.purchase.mail', $data);
            
        } catch (ModelNotFoundException $e) {
            return view('accounting.purchase.notfound');
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

                    $sale = Purchase::findOrFail($id);

                   
                    $enable_email = $this->custom->getSetting('ENABLE_EMAIL');
                    if(isset($enable_email) && $enable_email == 'true')
                    {
                     
                        $customer = Vendors::find($sale->customer_id);
                        $invoice_number = $sale->invoice_number;
                        $total = number_format($sale->sub_total - $sale->discount, 2);
                        $due_date = $this->custom->dateformat($sale->due_date);
                        $invoice_date = $this->custom->dateformat($sale->invoice_date);
                        $attachment = '';

                        if (starts_with(\Request::root(), 'http://'))
                        {
                            $domain = substr (\Request::root(), 7); 
                        }

                      
                        $invoice_url = 'www.'.$domain.'/view/purchase/invoice/'.($invoice_number);

                        //$invoice_url = url('view/purchase/invoice/'.($invoice_number));

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

                            $data['sale'] = [
                                'id' => $sale->id,
                                'inv_no' => $sale->invoice_number,
                                'inv_date' => $this->custom->dateformat($sale->invoice_date),
                                'due_date' => $this->custom->dateformat($sale->due_date),
                                'paid_status' => $sale->paid_status,
                                'discount' => $sale->discount,
                                'customer' => $sale->vendor,
                                'payments' => $sale->paid,
                                'details' => $sale->details,
                            ];

                            $data['currency'] = $this->custom->currencyFormatSymbol();

                            $pdf = PDF::loadView('accounting/purchase/pdf', $data, [], array(
                                'default_font' => 'Arial',
                                'title' => 'mPDF',
                                'display_mode' => 'fullpage',
                                'default_font' => 'helvetica',
                            ));

                            $pdf->save(storage_path('app/vouchers/'.$sale->invoice_number.'.pdf'));

                            $attachment = storage_path('app/vouchers/'.$sale->invoice_number.'.pdf');
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
            return view('accounting.purchase.notfound');
        }
    }


    public function show_invoice($inv_no = NULL)
    {
        try {
            
            if(is_null($inv_no)) return view('accounting.purchase.notfound');

            $data = [];
            $sale = Purchase::where('invoice_number', $inv_no)->first();
            
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
                            'amount' => number_format($payment->amount, 2),
                            'description' => $payment->description,
                            'total' => number_format($total, 2),
                            'balance' => number_format($balance, 2)
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


                $data['sale'] = [
                    'id' => $sale->id,
                    'inv_no' => $sale->invoice_number,
                    'inv_date' => $this->custom->dateformat($sale->invoice_date),
                    'due_date' => $this->custom->dateformat($sale->due_date),
                    'paid_status' => $sale->paid_status,
                    'discount' => $sale->discount,
                    'customer' => $sale->vendor,
                    'payments' => $sale->paid,
                    'details' => $sale->details,
                ];
            }

            $data['currency'] = $this->custom->currencyFormatSymbol();

            return view('accounting/purchase/invoice', $data);

        } catch (ModelNotFoundException $e) {
            return view('accounting.purchase.notfound');
        }
    }
}