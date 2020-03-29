<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Accounts\PurchaseLedger;
use App\Http\Models\Accounts\Purchase;
use App\Http\Models\Accounts\PurchaseDetail;
use App\Http\Models\Accounts\Vendors;
use App\Http\Controllers\Controller;
use App\Http\Models\Accounts\Trucks;
use Illuminate\Http\Request;
use App\Libraries\Customlib;
use Carbon\Carbon;
use Excel;
use DB;

class PurchaseReportsController extends Controller
{
    public function __construct(){
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

    		$data['customers'] = Vendors::select('id', 'first_name', 'last_name')->get();
            return view('accounting.reports.purchase', $data);
    		
    	} catch (ModelNotFoundException $e) {
    		
    	}
    }



    public function getPurchaseReport(Request $request)
    {
    	try {
    		
    		$data = [];
            $data['sales'] = [];

            $data['to'] = $request->input('to');
            $data['from'] = $request->input('from');
            $data['by_type'] = $request->input('by_type');
            $data['customer_id'] = $request->input('customer');
            $data['due_date'] = $request->input('due_date');

            $nice_to_date = Carbon::createFromFormat('m/d/Y', $data['to'])->toDateString();
            $nice_from_date = Carbon::createFromFormat('m/d/Y', $data['from'])->toDateString();
            
            

            $query = Purchase::query();

            if(isset($data['customer_id']) && $data['customer_id'] <> "")
            {
                $query->where('vendor_id', '=', $data['customer_id']);
            }
            elseif(isset($data['by_type']) && $data['by_type'] <> "")
            {
                $query->where('paid_status', '=', $data['by_type']);
            }

            elseif(isset($data['due_date']) && $data['due_date'] <> "")
            {
                $nice_due_date = Carbon::createFromFormat('m/d/Y', $data['due_date'])->toDateString();
                $query->where('due_date', '=', $nice_due_date);
            }
            else
            {
                $query->where('invoice_date', '>=', $nice_to_date);
                $query->where('invoice_date', '<=', $nice_from_date);
            }

            

            $sales = $query->get();

            $tlt_amt = 0; $tlt_paid_amt = 0; $tlt_qty=0;
            $data['tlt'] = [];
            if(isset($sales))
            {
                foreach($sales as $sale)
                {
                    $details=PurchaseDetail::where('sale_id','=',$sale['id'])->get();
                    foreach($details as $detail)
                    {
                    $data['sales'][] = [
                        'id' => $sale['id'],
                        'invoice_number' => $sale['invoice_number'],
                        'invoice_date' => $this->custom->dateformat($sale['invoice_date']),
                        'customer_name' => $sale->vendor->first_name.' '.$sale->vendor->last_name,
                        'customer_id' => $sale->vendor->id,
                        'due_date' => $this->custom->dateformat($sale['due_date']),
                        'rate' =>$detail->unit_price,
                        'qty' => $detail->qty,
                        'total' => number_format($sale['total'], 2),
                        'paid' => number_format($sale->paid->sum('amount'), 2)
                    ];
                    $tlt_qty= $tlt_qty + $detail->qty;
                    $tlt_amt = $tlt_amt + $sale['total'];
                    $tlt_paid_amt = $tlt_paid_amt + $sale->paid->sum('amount');
                }
                }
            }
            $data['tlt'] = [
                'tlt_amt' => number_format($tlt_amt, 2),
                'tlt_paid_amt' => number_format($tlt_paid_amt, 2),
                'tlt_qty' => number_format($tlt_qty, 2)
            ];

            $data['to_date'] = $this->custom->dateformat($nice_to_date);
            $data['from_date'] = $this->custom->dateformat($nice_from_date);
           
            $data['currency'] = $this->custom->currencyFormatSymbol();
            $data['customers'] = Vendors::select('id', 'first_name', 'last_name')->get();
            return view('accounting.reports.purchase', $data);

    	} catch (ModelNotFoundException $e) {
    		
    	}
    }



    public function paymentReport()
    {
        try {

            $data['customers'] = Vendors::select('id', 'first_name', 'last_name')->get();
            return view('accounting.reports.purchase_payments', $data);
            
        } catch (ModelNotFoundException $e) {
            
        }
    }


    public function getPaymentReport(Request $request)
    {
        try {

            if($request->method() == "POST")
            {

                $data['total'] = 0;
                $data['to'] = $request->input('to');
                $data['from'] = $request->input('from');
                $data['customer_id'] = $request->input('customer');
                $data['voucher_no'] = $request->input('voucher_no');

                $nice_to_date = Carbon::createFromFormat('m/d/Y', $data['to'])->toDateString();
                $nice_from_date = Carbon::createFromFormat('m/d/Y', $data['from'])->toDateString();

                $query = PurchaseLedger::query();
                $query->leftJoin('tbl_purchase', 'tbl_purchase.id', '=', 'tbl_purchase_ledger.sale_id');


                if($data['voucher_no'] <> "")
                {
                    $query->where('tbl_purchase.invoice_number', '=', $data['voucher_no']);
                }
                else if($data['customer_id'] <> "")
                {
                    $query->where('tbl_purchase_ledger.vendor_id', '=', $data['customer_id']);
                }
                else
                {
                    $query->where('tbl_purchase_ledger.date', '>=', $nice_to_date);
                    $query->where('tbl_purchase_ledger.date', '<=', $nice_from_date);
                }



                $rows = $query->get();

                $data['rows'] = [];
                if(isset($rows) )
                {

                    $total = 0;
                    foreach($rows as $row)
                    {

                        $total = $total + $row['amount'];
                        $data['rows'][] = [
                            'sale_id' => $row['sale_id'],
                            'payment_no' => $row['payment_no'],
                            'invoice_number' => $row['invoice_number'],
                            'invoice_date' => $this->custom->dateformat($row['date']),
                            'detail' => $row['description'],
                            'amount' => number_format($row['amount'], 2),
                            'total' => number_format($total, 2)
                        ];
                        
                    }

                    $end = end($data['rows']);
                    $data['total'] = $end['total'];
                }

              

                $data['currency'] = $this->custom->currencyFormatSymbol();

                $data['to_date'] = $this->custom->dateformat($nice_to_date);
                $data['from_date'] = $this->custom->dateformat($nice_from_date);

                $data['customers'] = Vendors::select('id', 'first_name', 'last_name')->get();
                return view('accounting.reports.purchase_payments', $data);

            }

            return redirect('/');
            
        } catch (ModelNotFoundException $e) {
            return redirect('/');
        }
    }


    public function paymentBalance()
    {
        try {

            $data['customers'] = Vendors::select('id', 'first_name', 'last_name')->get();
            return view('accounting.reports.purchase_balance', $data);
            
        } catch (ModelNotFoundException $e) {
            
        }
    }


    public function paymentBalanceReport(Request $request)
    {
        try {

            if($request->method() == "POST")
            {

                $data['customer_id'] = $request->input('customer');
                $data['voucher_no'] = $request->input('voucher_no');

                $query = Purchase::query();

                if($data['voucher_no'] <> "")
                {
                    $query->where('invoice_number', '=', $data['voucher_no']);
                }
                else if($data['customer_id']  <> "")
                {
                    $query->where('vendor_id', '=', $data['customer_id'] );
                }

                $rows = $query->get();

                $data['rows'] = [];
                $total = 0;

                if(!empty($rows))
                {
                    foreach($rows as $key => $row)
                    {

                        $data['customer_name'] = $row->vendor->first_name.' '.$row->vendor->last_name;
                        $preBalance = $row['total'];
                        if(!empty($row->paid))
                        {
                            
                            foreach($row->paid as $payment)
                            {

                                $balance = ($preBalance - $payment['amount']);

                                $data['rows'][] = [
                                    'sale_id' => $payment['sale_id'],
                                    'invoice_number' => $row['invoice_number'],
                                    'payment_no' => $payment['payment_no'],
                                    'payment_date' => $this->custom->dateformat($payment['date']),
                                    'detail' => '',
                                    'total' => number_format($row['total'], 2),
                                    'amount' => number_format($payment['amount'], 2),
                                    'balance' => number_format($balance, 2)
                                ];

                                $total = $total + $balance;

                                $preBalance = $balance;
                            }
                        }


                    }
                }

                $data['total'] = number_format($total, 2);
            
                $data['currency'] = $this->custom->currencyFormatSymbol();
                $data['customers'] = Vendors::select('id', 'first_name', 'last_name')->get();
                return view('accounting.reports.purchase_balance', $data);

            }

            return redirect('/');
            
        } catch (ModelNotFoundException $e) {
            return redirect('/');
        }
    }


    public function export(Request $request)
    {
        try {


            $action = $request->type;
            switch ($action) {

                case 'purchaseReport':

                    $data['to_date'] = $request->to;
                    $data['from_date'] = $request->from;
                    $data['by_type'] = $request->by_type;
                    $data['customer'] = $request->customer;
                   
                    $data['due_date'] = $request->due_date;

                    $data['nice_to_date'] = Carbon::createFromFormat('m/d/Y', $data['to_date'])->toDateString();
                    $data['nice_from_date'] = Carbon::createFromFormat('m/d/Y', $data['from_date'])->toDateString();

                    Excel::create(__('admin/reports.purchse_report_txt'), function($excel) use($data) {
                        
                        $excel->sheet(__('admin/reports.purchse_report_txt'), function($sheet) use($data) {

                            $sheet->mergeCells('A1:F1');

                            $sheet->setHeight(1, 50);
                            $sheet->cells('A1:F1', function($cells) {
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                                $cells->setFont(array(
                                        'family'     => 'Calibri',
                                        'size'       => '14',
                                        'bold'       => true
                                    )
                                );
                            });

                           
                            $sheet->row(1, array(__('admin/reports.purchse_report_txt').' ('.$this->custom->dateformat($data['nice_to_date']).' - '.$this->custom->dateformat($data['nice_from_date']).')'));

                            $sheet->cells('A2:F2', function($cells) {
                                $cells->setFont(array(
                                        'bold'       => true
                                    )
                                );
                            });

                            $sheet->row(2, array('Invoice Number', 'Customer Name', 'Invoice Date', 'Due Date', 'Total Amount', 'Paid Amount'));

                            $sheet->setColumnFormat(array(
                                'C' => 'dd-mm-yyyy',
                                'D' => 'dd-mm-yyyy',
                                'E' => '0.00',
                                'F' => '0.00',
                            ));
                           
                            $query = Purchase::query();

                            if(isset($data['customer']) && $data['customer'] <> "")
                            {
                                $query->where('vendor_id', '=', $data['customer']);
                            }

                            elseif(isset($data['by_type']) && $data['by_type'] <> "")
                            {
                                $query->where('paid_status', '=', $data['by_type']);
                            }

                            elseif(isset($data['due_date']) && $data['due_date'] <> "")
                            {
                                $nice_due_date = Carbon::createFromFormat('m/d/Y', $data['due_date'])->toDateString();
                                $query->where('due_date', '=', $nice_due_date);
                            }
                            else
                            {
                                $query->where('invoice_date', '>=', $data['nice_to_date']);
                                $query->where('invoice_date', '<=', $data['nice_from_date']);
                            }

                            

                            $sales = $query->get();

                            $tlt_amt = 0; $tlt_paid_amt = 0;
                            $data['tlt'] = [];
                            if(isset($sales) )
                            {
                                $r = 3;
                                foreach($sales as $sale)
                                {

                                    $sheet->cells('E'.$r.':F'.$r.'', function($cells) {
                                        $cells->setAlignment('right');
                                        $cells->setValignment('center');
                                    });

                                    $sheet->appendRow($r, array(
                                        $sale['invoice_number'], $sale->vendor->first_name.' '.$sale->vendor->last_name, $this->custom->dateformat($sale['invoice_date']), $this->custom->dateformat($sale['due_date']), number_format($sale['total'], 2), number_format($sale->paid->sum('amount'), 2)
                                    ));

                                    $tlt_amt = $tlt_amt + $sale['total'];
                                    $tlt_paid_amt = $tlt_paid_amt + $sale->paid->sum('amount');

                                    $r++;
                                }

                                $sheet->cells('A'.$r.':F'.$r.'', function($cells) {
                                    $cells->setFont(array(
                                            'bold'       => true
                                        )
                                    );
                                });

                                $sheet->appendRow($r, array('', '', '', 'Total', number_format($tlt_amt, 2), number_format($tlt_paid_amt, 2)));

                                
                            }


                        });

                    })->export('xls');


                break;

                case 'purchaseTransaction':
                    
                    $data['to'] = $request->input('to');
                    $data['from'] = $request->input('from');
                    $data['customer_id'] = $request->input('customer');
                    $data['voucher_no'] = $request->input('voucher_no');

                    $data['nice_to_date'] = Carbon::createFromFormat('m/d/Y', $data['to'])->toDateString();
                    $data['nice_from_date'] = Carbon::createFromFormat('m/d/Y', $data['from'])->toDateString();

                    Excel::create(__('admin/reports.purchse_payments_report_txt'), function($excel) use($data) {

                        $excel->sheet(__('admin/reports.purchse_payments_report_txt'), function($sheet) use($data) {

                            $sheet->mergeCells('A1:E1');

                            $sheet->setHeight(1, 50);
                            $sheet->cells('A1:E1', function($cells) {
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                                $cells->setFont(array(
                                        'family'     => 'Calibri',
                                        'size'       => '14',
                                        'bold'       => true
                                    )
                                );
                            });

                            $sheet->setColumnFormat(array(
                                'E' => '0.00',
                            ));


                            $sheet->row(1, array(__('admin/reports.purchse_payments_report_txt').' ('.$this->custom->dateformat($data['nice_to_date']).' - '.$this->custom->dateformat($data['nice_from_date']).')'));

                            $sheet->cells('A2:E2', function($cells) {
                                $cells->setFont(array(
                                        'bold'       => true
                                    )
                                );
                            });

                            $sheet->row(2, array(
                                __('admin/entries.pay_serial_no_txt'), 
                                __('admin/entries.voucher_number_txt'), 
                                __('admin/entries.date_label'), 
                                __('admin/entries.detail_txt'), 
                                __('admin/entries.paid_amount_txt')
                            ));


                            $query = PurchaseLedger::query();
                            $query->leftJoin('tbl_purchase', 'tbl_purchase.id', '=', 'tbl_purchase_ledger.sale_id');

                            if($data['voucher_no'] <> "")
                            {
                                $query->where('tbl_purchase.invoice_number', '=', $data['voucher_no']);
                            }
                            else if($data['customer_id'] <> "")
                            {
                                $query->where('tbl_purchase.vendor_id', '=', $data['customer_id']);
                            }
                            else
                            {
                                $query->where('tbl_purchase_ledger.date', '>=', $data['nice_to_date']);
                                $query->where('tbl_purchase_ledger.date', '<=', $data['nice_from_date']);
                            }

                            $rows = $query->get();

                            $data['rows'] = [];
                            if(isset($rows) )
                            {

                                $sub_total = 0;
                                $r=3;
                                foreach($rows as $row)
                                {

                                    $sheet->cells('E'.$r.'', function($cells) {
                                        $cells->setAlignment('right');
                                        $cells->setValignment('center');
                                    });

                                    $sheet->appendRow($r, array(
                                        $row['payment_no'], 
                                        $row['invoice_number'], 
                                        $this->custom->dateformat($row['date']), 
                                        $row['description'], 
                                        number_format($row['amount'], 2)
                                    ));

                                    $sub_total = $sub_total + $row['amount'];
                                    $r++;
                                    
                                }

                                $sheet->cells('A'.$r.':E'.$r.'', function($cells) {
                                    $cells->setFont(array(
                                            'bold'       => true
                                        )
                                    );
                                });

                                $sheet->appendRow($r, array('', '', '', 'Total', number_format($sub_total, 2)));
                            }


                        });

                    })->export('xls');

                break;

                case 'purchaseBalanceReport':

                    $data['customer_id'] = $request->customer;
                    $data['voucher_no'] = $request->voucher_no;

                    Excel::create(__('admin/reports.purchse_balance_report_txt'), function($excel) use($data) {

                        $excel->sheet(__('admin/reports.purchse_balance_report_txt'), function($sheet) use($data){

                            $sheet->mergeCells('A1:F1');

                            $sheet->setHeight(1, 50);
                            $sheet->cells('A1:F1', function($cells) {
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                                $cells->setFont(array(
                                        'family'     => 'Calibri',
                                        'size'       => '14',
                                        'bold'       => true
                                    )
                                );
                            });

                            

                            $sheet->cells('A3:F3', function($cells) {
                                $cells->setFont(array(
                                        'bold'       => true
                                    )
                                );
                            });

                            
                            $sheet->row(1, array(__('admin/reports.purchse_balance_report_txt')));

                            
                            $sheet->row(3, array(
                                __('admin/entries.pay_serial_no_txt'), 
                                __('admin/entries.voucher_number_txt'), 
                                __('admin/entries.payment_date_txt'), 
                                __('admin/entries.total_amount_txt'), 
                                __('admin/entries.paid_amount_txt'),
                                __('admin/entries.balace_amount_txt')
                            ));

                            $sheet->setColumnFormat(array(
                                'D' => '0.00',
                                'E' => '0.00',
                                'F' => '0.00',
                            ));

                            $query = Purchase::query();

                            if($data['voucher_no'] <> "")
                            {
                                $query->where('invoice_number', '=', $data['voucher_no']);
                            }
                            else if($data['customer_id']  <> "")
                            {
                                $query->where('vendor_id', '=', $data['customer_id'] );
                            }

                            $rows = $query->get();

                            $data['rows'] = []; $total = 0; $r=4; $sr = 4; $tlt_amt = 0;
                            if(count($rows) > 0)
                            {

                                $tlt_paid_amt = 0;
                                foreach($rows as $key => $row)
                                {

                                    $data['customer_name'] = $row->vendor->first_name.' '.$row->vendor->last_name;
                                    if(!empty($data['customer_name']) || !empty($data['voucher_no']))
                                    {
                                        $sheet->mergeCells('B2:C2');
                                        $sheet->mergeCells('E2:F2');
                                        $sheet->row(2, array(
                                             __('admin/entries.vendor_label'),
                                            $data['customer_name'],
                                            '',
                                            __('admin/entries.voucher_number_txt'), 
                                            $data['voucher_no'],
                                        ));
                                    }

                                    
                                    
                                    $preBalance = $row['total'];
                                    
                                    if(count($row->paid) > 0)
                                    {

                                        foreach($row->paid as $payment)
                                        {

                                            
                                            $balance = ($preBalance - $payment['amount']);

                                            $sheet->cells('D'.$r.':F'.$r.'', function($cells) {
                                                $cells->setAlignment('right');
                                                $cells->setValignment('center');
                                            });

                                            $sheet->appendRow($r, array(
                                                $payment['payment_no'],
                                                $row['invoice_number'], 
                                                $this->custom->dateformat($payment['date']), 
                                                number_format($row['total'], 2), 
                                                number_format($payment['amount'], 2),
                                                number_format($balance, 2)
                                            ));

                                           
                                            $r++; $sr++;

                                            $total = $total + $balance;
                                            $preBalance = $balance;
                                            $tlt_paid_amt = $tlt_paid_amt + $payment['amount'];
                                            
                                        }
                                        
                                        $tlt_amt = $tlt_amt + $row['total'];
                                    }
                                    
                                    
                                }
                                

                                $sheet->cells('A'.$sr.':F'.$sr.'', function($cells) {
                                    $cells->setFont(array(
                                            'bold'       => true
                                        )
                                    );
                                    $cells->setAlignment('right');
                                    $cells->setValignment('center');
                                });

                                $sheet->appendRow($sr, array(
                                    '', 
                                    '', 
                                     __('admin/entries.tlt_txt'),
                                    number_format($tlt_amt, 2), 
                                    number_format($tlt_paid_amt, 2),
                                    number_format($tlt_amt - $tlt_paid_amt, 2)
                                ));
                                
                            }

                        });

                    })->export('xls');

                   
                break;
                
                default:
                    return redirect('/');
                break;
            }
        } catch (ModelNotFoundException $e) {
            return redirect('/');
        }
    }

}
