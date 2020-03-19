<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Accounts\AccountsController;
use App\Http\Models\Accounts\AccountsChart;
use App\Http\Models\Accounts\SalesLedger;
use App\Http\Models\Accounts\Customers;
use App\Http\Controllers\Controller;
use App\Http\Models\Accounts\Sales;
use App\Jobs\SendCustomerEmailJob;
use Illuminate\Http\Request;
use App\Libraries\Customlib;
use Carbon\Carbon;
use DB;

class CustomersController extends Controller
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

          $name = \Request::get('name');
          $email = \Request::get('email');


          $data['per_page'] = \Request::get('per_page') ?: 12;

          $qry = Customers::query();
          if(isset($name) && $name <> "")
          {
            $qry->where('first_name', 'LIKE', "%$name%");
            $qry->orWhere('last_name', 'LIKE', "%$name%");
          }

          if(isset($email) && $email <> "")
          {
            $qry->where('email', 'LIKE', "%$email%");
          }

          $data['customers'] = $qry->paginate($data['per_page']);
          
          return view('accounting.customers.index', $data);
            
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

            $account = AccountsChart::where('type_id', '17')
                ->orderBy('id', 'DESC')
                ->first();

            $data['code'] = '';
            if(isset($account) )
            {
                $account_code = $account->code+1;
                $data['code'] = '0'.$account_code;
            }

            $data['countries'] = DB::table('tbl_countries')->select('id', 'country_name')->get();
            return view('accounting.customers.create', $data);
            
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
                'code' => 'required|unique:tbl_accounts_chart',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:tbl_customers',
                'phone' => 'required|max:14',
                'mobile' => 'max:14',
                'present_address' => 'required',
                'nationality' => 'required'
            ]);
           

            $customer = new Customers;
            $customer->code = $request->input('code');
            $customer->first_name = $request->input('first_name');
            $customer->last_name = $request->input('last_name');
            $customer->email = $request->input('email');
            $customer->company = $request->input('company');
            $customer->phone = $request->input('phone');
            $customer->mobile = $request->input('mobile');
            $customer->fax = $request->input('fax');
            $customer->present_address = $request->input('present_address');
            $customer->permanent_address = $request->input('permanent_address');
            $customer->country_id = $request->input('nationality');
            $customer->state = $request->input('state');
            $customer->city = $request->input('city');
            $customer->postal_code = $request->input('postal_code');
            $customer->other = $request->input('reference');
            $customer->save();
            
            if($customer)
            {

                $account = new AccountsChart;
                $account->code = $request->input('code');
                $account->name = $request->input('first_name').' '.$request->input('last_name');
                $account->type_id = '17';
                $account->opening_balance = '0';
                $account->balance_type = 'dr';
                $account->is_systemize = '0';
                $account->save();
                
                $request->session()->flash('msg', __('admin/customers.customers_added'));
            }

            
            $enable_email = $this->custom->getSetting('ENABLE_EMAIL');
            if(isset($enable_email) && $enable_email == 'true')
            {
                $template = $this->custom->getTemplate(16);

                if(isset($template['status']) && $template['status'] == 1)
                {
                	$dd = [
	                        'first_name' => $request->input('first_name'),
	                        'last_name' => $request->input('last_name'),
	                        'template_id' => '16',
	                        'email' => $request->input('email'),
	                        
	                ];
              
                	$job = (new SendCustomerEmailJob($dd))->delay(Carbon::now()->addSeconds(10));
                  dispatch($job);
		
                	
                }

            }
            

            return redirect('accounting/customers/add');
            
        } catch (ModelNotFoundException $e) {
             return redirect('accounting/customers/add');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function show($id = NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/customers');
            
            $data = [];
            $s = [];
            $rc = [];

            $customer = Customers::findOrFail($id);

            $ac = (new AccountsController);

            $data['customer'] = $customer;


            $str_month = date('Y-m'.'-01', time());
            $end_month = date('Y-m'.'-01', strtotime("-11 month"));

            $end  = strtotime($str_month);
            $start = $month = strtotime($end_month);

            $customers_sales = $this->getSalesByCustomer($id);
            $customers_recieved = $this->getSalesReceivedByCustomer($id);

            while ($month <= $end) {

                $total_month[] = date('M Y', $month);

                $m = date('m', $month);
                
                $key = "month";

                $sreturn = $ac->whatever($customers_sales, $key, $m);
                if($sreturn)
                {
                    $s[] = $sreturn;
                }else{
                    $s[] = '0.00';
                }


                $preturn = $ac->whatever($customers_recieved, $key, $m);
                if($preturn)
                {
                    $rc[] = $preturn;
                }else{
                    $rc[] = '0.00';
                }

                $month = strtotime("+1 month", $month);
            }
           
            $data['total_month'] = $total_month;

            $data['status'] = $this->getinvoiceStatusByCustomer($id);
            $data['total_order_amount'] = $this->getTotalOrderAmountByCustomer($id);
            $data['total_received'] = $this->getTotalRecAmountByCustomer($id);
            $data['total_pending'] = $data['total_order_amount'] - $data['total_received'];
            $data['sales_chart'] = $s;
            $data['sales_received'] = $rc;
            $data['recents'] = $ac->recentsInvoices(5, $id);

            $data['currency'] = $this->custom->currencyFormatSymbol();

            return view('accounting/customers/view', $data);
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/customers');
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getinvoiceStatusByCustomer($id = NULL)
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
            )
            ->where('customer_id', $id)
            ->first();

            if(isset($sales) )
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
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Sales
     * @return \Illuminate\Http\Response
     */

    public function getSalesByCustomer($id = NULL)
    {
        try {
            
            $ch = DB::table('tbl_sales')
              ->select(DB::raw('MONTH(invoice_date) as month, YEAR(invoice_date) as year, SUM(total) as t'))
              ->whereRaw('invoice_date > DATE_SUB(now(), INTERVAL 12 MONTH)')
              ->groupBy(DB::raw('YEAR(invoice_date), MONTH(invoice_date)'))
              ->where('customer_id', $id)
              ->get()->toArray();
              $inc = [];
              if(isset($ch) )
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


    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Sales
     * @return \Illuminate\Http\Response
     */

    public function getSalesReceivedByCustomer($id = NULL)
    {
        try {
            
            $ch = DB::table('tbl_sales_ledger')
              ->select(DB::raw('MONTH(date) as month, YEAR(date) as year, SUM(amount) as t'))
              ->whereRaw('date > DATE_SUB(now(), INTERVAL 12 MONTH)')
              ->groupBy(DB::raw('YEAR(date), MONTH(date)'))
              ->where('customer_id', $id)
              ->get()->toArray();
              $inc = [];
              if(isset($ch) )
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

    

     /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Sales
     * @return \Illuminate\Http\Response
     */

     public function getTotalOrderAmountByCustomer($id = NULL)
     {
        try {

            $customer = Sales::select(
                DB::raw('SUM(total) as total_sales')
            )
            ->where('customer_id', $id)
            ->groupBy('customer_id')
            ->first();

            if(isset($customer) ){
                return $customer->total_sales;
            }

            return '0.00';
            
        } catch (ModelNotFoundException $e) {
            
        }
     }


     /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Sales
     * @return \Illuminate\Http\Response
     */

     public function getTotalRecAmountByCustomer($id = NULL)
     {
        try {

            $customer = SalesLedger::select(
                DB::raw('SUM(amount) as total_rec')
            )
            ->where('customer_id', $id)
            ->groupBy('customer_id')
            ->first();

            if(isset($customer) ){
                return $customer->total_rec;
            }

            return '0.00';
            
        } catch (ModelNotFoundException $e) {
            
        }
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function edit($id=NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/customers');

            $data = [];

            $data['customer'] = Customers::findOrFail($id);

            $data['countries'] = DB::table('tbl_countries')->select('id', 'country_name')->get();
            return view('accounting.customers.edit', $data);
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/customers');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Accounts\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id=NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/customers');

            $customer = Customers::findOrFail($id);

            $this->validate($request, [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:tbl_customers,email,'.$customer->id,
                'phone' => 'required',
                'present_address' => 'required',
                'nationality' => 'required'
            ]);

            $customer->first_name = $request->input('first_name');
            $customer->last_name = $request->input('last_name');
            $customer->email = $request->input('email');
            $customer->company = $request->input('company');
            $customer->phone = $request->input('phone');
            $customer->mobile = $request->input('mobile');
            $customer->fax = $request->input('fax');
            $customer->present_address = $request->input('present_address');
            $customer->permanent_address = $request->input('permanent_address');
            $customer->country_id = $request->input('nationality');
            $customer->state = $request->input('state');
            $customer->city = $request->input('city');
            $customer->postal_code = $request->input('postal_code');
            $customer->other = $request->input('reference');
            $customer->save();
            
            if($customer)
            {
                $request->session()->flash('msg', __('admin/customers.customers_update'));
            }

            return redirect('accounting/customers/edit/'.$id);
            
        } catch (ModelNotFoundException $e) {
             return redirect('accounting/customers');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Models\Accounts\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function destroy($id=NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/customers');

            $customer = Customers::findOrFail($id);

            $delete = $customer->delete();
            if($delete)
            {
                \Request::session()->flash('msg', __('admin/customers.delete_msg'));
            }

            return redirect('accounting/customers');

            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/customers');
        }
    }

}
