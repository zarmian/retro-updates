<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Models\Accounts\Trucks;
use App\Http\Models\Accounts\TruckDetail;
use App\Http\Models\Accounts\Product;
use Illuminate\Http\Request;
use App\Libraries\Customlib;
use Carbon\Carbon;
use Validator;
use Storage;
use Auth;
use DB;
use PDF;
use URL;


class TrucksController extends Controller
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
            $data['trucks'] = [];

            $data['per_page'] = \Request::get('per_page') ?: 12;

            $qry = Trucks::query();

            if(\Request::has('name'))
            {
                $name = \Request::get('name');
                $qry->where('name', 'LIKE', "%$name%");
                
            }

        
            
            $qry->orderBy('id', 'DESC');
            
            
            $trucks = $qry->paginate($data['per_page']);
           
            
            if(isset($trucks) )
            {
                foreach($trucks as $truck)
                {
                    $products=[];
                    $productdetails = TruckDetail::where('truck_id', $truck->id)->get();
                    if(isset($productdetails))
                    {
                        
                        foreach($productdetails as $product)
                        {
                    $products[]=[
                        'name'=>$product->products->name,
                        'quantity'=>number_format($product->quantity, 0),
                    ];
                        }
                    }
                    
                    
                    $data['trucks'][] = [
                        'id' => $truck->id,
                        'name' => $truck->name,
                        'products' => $products,
                        
                        
                    ];
                }
            }
            

            $data['pages'] = $trucks->appends(\Input::except('page'))->render();
            

            return view('accounting/trucks/index', $data);
            
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


            return view('accounting/trucks/create');

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
                'number' => 'required',
            ]);

         

            $sale = new Trucks;
            $sale->name = $request->input('number');
      
            $sale->save();


            $request->session()->flash('msg', __('Truck has been added successfully.'));
            return redirect('accounting/trucks/add');
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/sales');
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

            if(is_null($id)) return redirect('accounting/trucks');

            $data = [];
            $data['product'] = Trucks::findOrFail($id);

            return view('accounting/trucks/edit', $data);
            
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

            if(is_null($id)) return redirect('accounting/trucks');

            $this->validate($request, [
                'name' => 'required',
                'price' => 'required',
            ]);


            $sale = Trucks::findOrFail($id);

            $sale->name = $request->input('name');
            $sale->price = $request->input('price');
            $sale->save();



            $request->session()->flash('msg', __('Product has been updated successfully.'));
            return redirect('accounting/trucks/edit/'.$id);
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/trucks');
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

            if(is_null($id)) return redirect('accounting/trucks');

            $sale = Trucks::findOrFail($id);
            $delete = $sale->delete();
            if($sale)
            {
                \Request::session()->flash('msg', __('Truck has been deleted successfully.'));
            }

            return redirect('accounting/trucks');

        } catch (ModelNotFoundException $e) {
             return redirect('accounting/trucks');
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



    public function ajax_products(Request $request){

        $id = $request->input('id');
        if($id <> ""){
            $products=[];
            $rows = TruckDetail::where('truck_id','=',$id)->get();
            $len= $rows->count();
            if(isset($rows))
            {
                foreach($rows as $row)
                {
                    $products[]=[
                        'id'=> $row->product_id,
                        'name' => $row->products->name,
                        'qty' => $row->quantity,
                    ];
                }
            }
            
            
            return response()->json(['error'=> '0','len'=> $len, 'data' => $products]);

        }else{
            return response()->json(['error'=> '1', 'row' => 'Sorry! Email has been disabled, please check your setting.']);
        }
        
    }
    public function addproduct()
    {
        try {

            $data = [];
            $data['trucks'] = Trucks::get();
            $data['products'] = Product::get();

            return view('accounting/trucks/addproducts', $data);

        } catch (ModelNotFoundException $e) {
            return redirect('accounting/sales');
        }
    }
    public function storeproduct(Request $request)
    {
        try {
            

            $this->validate($request, [
                'trucks' => 'required',
                'products' => 'required',
            ]);

         

            $sale = new TruckDetail;
            $sale->truck_id = $request->input('trucks');
            $sale->product_id = $request->input('products');

      
            $sale->save();


            $request->session()->flash('msg', __('Product has been added to Truck successfully.'));
            return redirect('accounting/trucks/addproducts');
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/sales');
        }
    }
}