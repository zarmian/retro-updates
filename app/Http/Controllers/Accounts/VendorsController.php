<?php
namespace App\Http\Controllers\Accounts;

use App\Http\Models\Accounts\Vendors;
use App\Http\Models\Accounts\PurchaseLedger;
use App\Http\Models\Accounts\Purchase;
use App\Http\Models\Accounts\AccountsChart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Libraries\Customlib;
use DB;

class VendorsController extends Controller
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

          $qry = Vendors::query();
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

          return view('accounting.vendors.index', $data);
            
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

            $data['code'] = '';

            $account = AccountsChart::orWhere('type_id', '11')
                ->orWhere('type_id', '10')
                ->orWhere('type_id', '5')
                ->orderBy('id', 'DESC')
                ->first();

            $data['code'] = '';
            if(isset($account) && count($account) > 0)
            {
                $account_code = $account->code+1;
                $data['code'] = '0'.$account_code;
            }

            $data['countries'] = DB::table('tbl_countries')->select('id', 'country_name')->get();
            return view('accounting.vendors.create', $data);
            
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
                'email' => 'required|email|unique:tbl_vendors',
                'phone' => 'required|max:14',
                'mobile' => 'max:14',
                'present_address' => 'required',
                'nationality' => 'required'
            ]);

            $vendors = new Vendors;
            $vendors->code = $request->input('code');
            $vendors->first_name = $request->input('first_name');
            $vendors->last_name = $request->input('last_name');
            $vendors->email = $request->input('email');
            $vendors->company = $request->input('company');
            $vendors->phone = $request->input('phone');
            $vendors->mobile = $request->input('mobile');
            $vendors->fax = $request->input('fax');
            $vendors->present_address = $request->input('present_address');
            $vendors->permanent_address = $request->input('permanent_address');
            $vendors->country_id = $request->input('nationality');
            $vendors->state = $request->input('state');
            $vendors->city = $request->input('city');
            $vendors->postal_code = $request->input('postal_code');
            $vendors->other = $request->input('reference');
            $vendors->save();

            if($vendors)
            {

                $account = new AccountsChart;
                $account->code = $request->input('code');
                $account->name = $request->input('first_name').' '.$request->input('last_name');
                $account->type_id = '11';
                $account->opening_balance = '0';
                $account->balance_type = 'cr';
                $account->is_systemize = '0';
                $account->save();


                $request->session()->flash('msg', __('admin/vendors.vendors_added'));
            }

            return redirect('accounting/vendors/add');


        } catch (ModelNotFoundException $e) {
            
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

            $customer = Vendors::findOrFail($id);

            $ac = (new AccountsController);

            $data['customer'] = $customer;


            $str_month = date('Y-m'.'-01', time());
            $end_month = date('Y-m'.'-01', strtotime("-11 month"));

            $end  = strtotime($str_month);
            $start = $month = strtotime($end_month);

            $vendor_sales = $this->getSalesByVendor($id);
            $vendor_recieved = $this->getSalesReceivedByVendor($id);

            while ($month <= $end) {

                $total_month[] = date('M Y', $month);

                $m = date('m', $month);
                
                $key = "month";

                $sreturn = $ac->whatever($vendor_sales, $key, $m);
                if($sreturn)
                {
                    $s[] = $sreturn;
                }else{
                    $s[] = '0.00';
                }


                $preturn = $ac->whatever($vendor_recieved, $key, $m);
                if($preturn)
                {
                    $rc[] = $preturn;
                }else{
                    $rc[] = '0.00';
                }

                $month = strtotime("+1 month", $month);
            }
           
            $data['total_month'] = $total_month;

            $data['status'] = $this->getinvoiceStatusByVendor($id);
            $data['total_order_amount'] = $this->getTotalOrderAmountByVendor($id);
            $data['total_received'] = $this->getTotalRecAmountByVendor($id);
            $data['total_pending'] = $data['total_order_amount'] - $data['total_received'];
            $data['sales_chart'] = $s;
            $data['sales_received'] = $rc;
            $data['recents'] = $this->recentsInvoices(5, $id);

            $data['currency'] = $this->custom->currencyFormatSymbol();

            return view('accounting/vendors/view', $data);
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/vendors');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Sales
     * @return \Illuminate\Http\Response
     */

    public function getSalesByVendor($id = NULL)
    {
        try {
            
            $ch = DB::table('tbl_purchase')
              ->select(DB::raw('MONTH(invoice_date) as month, YEAR(invoice_date) as year, SUM(total) as t'))
              ->whereRaw('invoice_date > DATE_SUB(now(), INTERVAL 12 MONTH)')
              ->groupBy(DB::raw('YEAR(invoice_date), MONTH(invoice_date)'))
              ->where('vendor_id', $id)
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Sales
     * @return \Illuminate\Http\Response
     */

    public function getSalesReceivedByVendor($id = NULL)
    {
        try {
            
            $ch = DB::table('tbl_purchase_ledger')
              ->select(DB::raw('MONTH(date) as month, YEAR(date) as year, SUM(amount) as t'))
              ->whereRaw('date > DATE_SUB(now(), INTERVAL 12 MONTH)')
              ->groupBy(DB::raw('YEAR(date), MONTH(date)'))
              ->where('vendor_id', $id)
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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getinvoiceStatusByVendor($id = NULL)
    {
        try {

            $status = [];

            $sales = Purchase::select(
                
                DB::raw('(
                    SELECT COUNT(s.paid_status) FROM `tbl_purchase` s
                    WHERE s.paid_status = "1"
                ) AS tlt_paid'),
                DB::raw('(
                    SELECT COUNT(s.paid_status) FROM `tbl_purchase` s
                    WHERE s.paid_status = "2"
                ) AS tlt_partial'),
                DB::raw('(
                    SELECT COUNT(s.paid_status) FROM `tbl_purchase` s
                    WHERE s.paid_status = "3"
                ) AS tlt_unpaid')
            )
            ->where('vendor_id', $id)
            ->first();

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
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Sales
     * @return \Illuminate\Http\Response
     */

     public function getTotalOrderAmountByVendor($id = NULL)
     {
        try {

            $customer = Purchase::select(
                DB::raw('SUM(total) as total_sales')
            )
            ->where('vendor_id', $id)
            ->groupBy('vendor_id')
            ->first();

            if(isset($customer) && count($customer)){
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

     public function getTotalRecAmountByVendor($id = NULL)
     {
        try {

            $customer = PurchaseLedger::select(
                DB::raw('SUM(amount) as total_rec')
            )
            ->where('vendor_id', $id)
            ->groupBy('vendor_id')
            ->first();

            if(isset($customer) && count($customer)){
                return $customer->total_rec;
            }

            return '0.00';
            
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

            $sales = Purchase::query();

            $sales->select(
                'id',
                'invoice_number',
                'invoice_date',
                'sub_total',
                'discount',
                'paid_status',
                'vendor_id'
            );
            if(isset($id) && !is_null($id) && $id <> "")
            {
              $sales->where('vendor_id', $id);
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
                        'customer' => $sale->vendor->first_name.' '.$sale->vendor->last_name
                    ];
                }
            }

            return $s;

        } catch (ModelNotFoundException $e) {
            
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Accounts\Vendors  $vendors
     * @return \Illuminate\Http\Response
     */
    public function edit($id=NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/vendors');

            $data = [];

            $data['customer'] = Vendors::findOrFail($id);

            $data['countries'] = DB::table('tbl_countries')->select('id', 'country_name')->get();
            return view('accounting.vendors.edit', $data);
            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/vendors');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Accounts\Vendors  $vendors
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id=NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/vendors');

            $vendors = Vendors::findOrFail($id);

            $this->validate($request, [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:tbl_vendors,email,'.$vendors->id,
                'phone' => 'required|max:14',
                'mobile' => 'max:14',
                'present_address' => 'required',
                'nationality' => 'required'
            ]);

            $vendors->first_name = $request->input('first_name');
            $vendors->last_name = $request->input('last_name');
            $vendors->email = $request->input('email');
            $vendors->company = $request->input('company');
            $vendors->phone = $request->input('phone');
            $vendors->mobile = $request->input('mobile');
            $vendors->fax = $request->input('fax');
            $vendors->present_address = $request->input('present_address');
            $vendors->permanent_address = $request->input('permanent_address');
            $vendors->country_id = $request->input('nationality');
            $vendors->state = $request->input('state');
            $vendors->city = $request->input('city');
            $vendors->postal_code = $request->input('postal_code');
            $vendors->other = $request->input('reference');
            $vendors->save();
            
            if($vendors)
            {
                $request->session()->flash('msg', __('admin/vendors.vendors_update'));
            }

            return redirect('accounting/vendors/edit/'.$id);
            
        } catch (ModelNotFoundException $e) {
             return redirect('accounting/vendors');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Models\Accounts\Vendors  $vendors
     * @return \Illuminate\Http\Response
     */
    public function destroy($id=NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/vendors');

            $customer = Vendors::findOrFail($id);

            $delete = $customer->delete();
            if($delete)
            {
                \Request::session()->flash('msg', __('admin/vendors.delete_msg'));
            }

            return redirect('accounting/vendors');

            
        } catch (ModelNotFoundException $e) {
            return redirect('accounting/vendors');
        }
    }


    
}
