<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Models\Accounts\Customers;
use App\Http\Models\Accounts\Vendors;
use App\Http\Models\Accounts\Sales;
use App\Http\Models\Accounts\Purchase;
use App\Http\Models\Accounts\SalesLedger;
use App\Http\Models\Accounts\PurchaseLedger;
use App\Http\Models\Accounts\AccountsSummeryDetail;
use App\Http\Models\Accounts\AccountsSummery;
use App\Http\Models\Admin\Employees;
use App\Http\Models\Employees\EmployeesAttendance;
use App\Jobs\DailyActivityEmailJob;
use Carbon\Carbon;
use DB;

class DailyEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $tlt_customer = Customers::where('created_at', '>=', 'CURRENT_DATE')
                    ->where('created_at', '<', 'CURRENT_DATE + INTERVAL 1 DAY')->count();

        $tlt_vendors = Vendors::where('created_at', '>=', 'CURRENT_DATE')
                    ->where('created_at', '<', 'CURRENT_DATE + INTERVAL 1 DAY')->count();

        $invoice = Sales::select(DB::raw('COUNT(id) as tlt_inv, SUM(total) as tlt_amt'))
                  ->whereRaw('Date(created_at) = CURDATE()')->first();

        $purchase = Purchase::select(DB::raw('COUNT(id) as tlt_inv, SUM(total) as tlt_amt'))
                  ->whereRaw('Date(created_at) = CURDATE()')->first();

        $recieved = SalesLedger::select(DB::raw('COALESCE(SUM(amount),0) as tlt_amt'))
                  ->whereRaw('Date(created_at) = CURDATE()')->first();

        $paid = PurchaseLedger::select(DB::raw('COALESCE(SUM(amount),0) as tlt_amt'))
                  ->whereRaw('Date(created_at) = CURDATE()')->first();

        $tlt_employees = Employees::where('role', '<>', '1')->where('status', '1')->count();
        
        $present_employees = EmployeesAttendance::select('in_time', 'employee_id', DB::raw('MONTH(in_time), YEAR(in_time), COUNT(id) as d'))->whereRaw('Date(in_time) = CURDATE()')->groupBy('employee_id', DB::raw('DATE(in_time)'), 'in_time')->count();
        
        $time_short_employees = EmployeesAttendance::select('in_time', 'employee_id', DB::raw('MONTH(in_time), YEAR(in_time), COUNT(id) as d'))->whereRaw('Date(in_time) = CURDATE()')->whereNull('out_time')->groupBy('employee_id', DB::raw('DATE(in_time)'), 'in_time')->count();

        $absent_employees = $tlt_employees - $present_employees;

        $journal_expense = AccountsSummery::select(DB::raw('tbl_accounts_summery_detail.id,  COALESCE(SUM(tbl_accounts_summery_detail.credit),0) as tlt_cr, COALESCE(SUM(tbl_accounts_summery_detail.debit),0) as tlt_dr'))->join('tbl_accounts_summery_detail', 'tbl_accounts_summery.id', '=', 'tbl_accounts_summery_detail.summery_id')
        ->where('tbl_accounts_summery.type', 1)->whereRaw('Date(tbl_accounts_summery.created_at) = CURDATE()')->groupBy('tbl_accounts_summery_detail.id')->first();


        $bank_cash = AccountsSummeryDetail::select(DB::raw('tbl_accounts_summery_detail.id,  COALESCE(SUM(tbl_accounts_summery_detail.credit),0) as tlt_cr, COALESCE(SUM(tbl_accounts_summery_detail.debit),0) as tlt_dr'))->join('tbl_accounts_chart', 'tbl_accounts_chart.id', '=', 'tbl_accounts_summery_detail.account_id')->whereRaw('Date(tbl_accounts_summery_detail.created_at) = CURDATE()')->where('tbl_accounts_chart.type_id', '9')->groupBy('tbl_accounts_summery_detail.id')->first();

        $data = [
            'customers' => $tlt_customer,
            'vendors' => $tlt_vendors,
            'invoice' => $invoice->tlt_inv,
            'purchase' => $purchase->tlt_inv,
            'recieved' => $recieved->tlt_amt,
            'paid' => $paid->tlt_amt,
            'total_employees' => $tlt_employees,
            'today_total_present_employees' => $present_employees,
            'today_total_absent_employees' => $absent_employees,
            'today_total_short_attendance' => $time_short_employees,
            'journal_expense_debit' => $journal_expense['tlt_dr'],
            'journal_expense_credit' => $journal_expense['tlt_cr'],
            'bank_cash_debit' => $bank_cash['tlt_dr'],
            'bank_cash_credit' => $bank_cash['tlt_cr'],

        ];

        $job = (new DailyActivityEmailJob($data))->delay(Carbon::now()->addSeconds(10));
        
        dispatch($job);
        //\Log::info('Total Customers: '. $tlt_customer);
    }
}
