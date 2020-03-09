<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Admin\EmployeesLoansStatements;
use App\Http\Models\Admin\EmployeesLoans;
use App\Jobs\SendLoanApprovalEmailJob;
use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Employees;
use Illuminate\Http\Request;
use App\Libraries\Customlib;
use Carbon\Carbon;
use Auth;
use DB;

class EmployeesLoansController extends Controller
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
            
            $data['per_page'] = \Request::get('per_page') ?: 12;

            
            $employees = EmployeesLoans::with([
            'employee' => function($query) {
                    $query->select(
                        'id', 
                        'first_name', 
                        'last_name', 
                        'department_id'
                    )->groupBy('id', 'first_name', 'last_name', 'department_id');
                }
            ])->select('employee_id', DB::raw('SUM(amount) As tlt_amt'))->groupBy(
                'tbl_employees_loans.employee_id'
            )->paginate();

            if(isset($employees) && count($employees) > 0)
            {
                foreach($employees as $employee)
                {
                    $data['employees'][] = [
                        'employee_id' => $employee->employee_id,
                        'name' => $employee['employee']->fullName(),
                        'amount' => number_format($employee->tlt_amt, 2),
                    ];
                }
            }

       
            $total_loans = Employees::with(
                ['loan_statements' => function($query){ 
                    $query->select(
                        DB::raw('SUM(withdraw) As tlt_withdraw'), 
                        DB::raw('SUM(deposit) As tlt_deposit'),
                        DB::raw('employee_id')
                    )->groupBy('employee_id');
                }])->select('id')->groupBy('id')->get()->toArray();



            if(isset($total_loans)){

                $tlt_withdraw = 0;
                $tlt_deposit = 0;
                foreach($total_loans as $loan){
                    
                    $tlt_withdraw = $loan['loan_statements']['tlt_withdraw'];
                    $tlt_deposit = $loan['loan_statements']['tlt_deposit'];

                    $data['tlt_loan'][$loan['id']] = array(
                        'withdraw' => number_format($tlt_withdraw, 2),
                        'deposit' => number_format($tlt_deposit, 2),
                        'tlt_balance' => number_format(($loan['loan_statements']['tlt_withdraw']) - ($loan['loan_statements']['tlt_deposit']), 2)
                    );
                   
                }
            }


            return view('admin.employees.loans.manage', $data);

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

            $data['employees'] = Employees::where('status', '1')->where('role','!=', '1')->get();
            return view('admin.employees.loans.create', $data);

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
                'date' => 'required',
                'detail' => 'required',
                'employee_id' => 'required',
                'type' => 'required',
                'amount' => 'required|numeric|between:0,1000000',
            ]);

            $user_id = Auth::guard('auth')->user()->id;
            $date = Carbon::createFromFormat('m/d/Y', $request->input('date'))->toDateString();
            
            $loan = new EmployeesLoans;

            $loan->employee_id = $request->input('employee_id');
            $loan->datetime = $date;
            $loan->title = $request->input('detail');
            $loan->detail = $request->input('detail');
            $loan->amount = $request->input('amount');
            $loan->type = $request->input('type');
            $loan->installment = $request->input('installment');
            $loan->unread = '0';
            $loan->status = '1';
            $loan->approved_by = $user_id;
            $loan->added_by = $user_id;
            $loan->save();

            if($loan){

                $loan_statement = new EmployeesLoansStatements;
                $loan_statement->employee_id = $request->input('employee_id');
                $loan_statement->datetime = $date;
                $loan_statement->detail = $request->input('detail');
                $loan_statement->deposit = '0';
                $loan_statement->withdraw = $request->input('amount');
                $loan_statement->type = $request->input('type');
                $loan_statement->added_by = $user_id;
                $loan_statement->save();

                $request->session()->flash('msg', __('admin/loans.added_msg'));
            }

            return redirect('/employees/loans/create');

        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Admin\EmloyeesLoans  $emloyeesLoans
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id=NULL)
    {
        try {

            if(is_null($id)) return redirect('/employees/loans');
            $data = [];

            $loan = EmployeesLoans::whereId($id)->first();


            if($request->input() && count($request->input()) > 0){


                DB::table('tbl_employees_loans')
                ->where('id', $loan->id)
                ->update([
                    'status' => $request->input('status'),
                    'approve_detail' => $request->input('detail'),
                    'installment' => $request->input('installment')
                ]);

                $enable_email = $this->custom->getSetting('ENABLE_EMAIL');
                if(isset($enable_email) && $enable_email == 'true')
                {

                    $template = $this->custom->getTemplate(17);
                    if(isset($template['status']) && $template['status'] == 1)
                    {

                        switch ($request->input('status')) {
                            case '2':
                                $status = __('admin/loans.reject_txt');
                            break;
                            case '1':
                                $status = __('admin/loans.accpect_txt');
                            break;
                            default:
                                $status = __('admin/loans.pending_txt');
                            break;
                        }

                        $dd = [
                            'employee_name' => $loan->employee->first_name.' '.$loan->employee->last_name,
                            'loan_amount' => $loan->amount,
                            'loan_reason' => $loan->detail,
                            'loan_status' => $status,
                            'approval_date' => $this->custom->dateformat($loan->datetime),
                            'employee_id' => $loan->employee_id
                        ];

                        $job = (new SendLoanApprovalEmailJob($dd))->delay(Carbon::now()->addSeconds(10));
                        dispatch($job);

                    }
                }
               

                if($request->input('status') && $request->input('status') == 1){

                    $user_id = Auth::guard('auth')->user()->id;

                    $loan_statement = new EmployeesLoansStatements;
                    $loan_statement->employee_id = $loan->employee_id;
                    $loan_statement->datetime = date('Y-m-d', strtotime($loan->datetime));
                    $loan_statement->detail = $request->input('detail');
                    $loan_statement->deposit = '0';
                    $loan_statement->withdraw = $loan->amount;
                    $loan_statement->type = $loan->type;
                    $loan_statement->added_by = $user_id;
                    $loan_statement->save();

                }

                $request->session()->flash('msg', __('admin/loans.status_update_msg'));
            }
          

            $data['loan'] = [
                'id' => $loan->id,
                'title' => $loan->title,
                'employee_name' => $loan->employee->first_name.' '.$loan->employee->last_name,
                'date' => date('d, M Y', strtotime($loan->datetime)),
                'status' => $loan->status,
                'description' => $loan->detail,
                'approved_description' => $loan->approve_detail,
                'amount' => $loan->amount,
            ];

            if($loan->unread == 1){
                $loan->unread = '0';
                $loan->save();
            }
            

            return view('admin.employees.loans.view', $data);
            
        } catch (ModelNotFoundException $e) {
            return redirect('/employees/loans');
        }
    }

    
    public function viewStatment()
    {
        try {

            $data = [];

            $data['employees'] = Employees::where('role', '<>', '1')->where('status', '1')->get();
            return view('admin.employees.loans.statement', $data);
            
        } catch (ModelNotFoundException $e) {
            
        }
    }


    public function getStatment(Request $request)
    {
        try {

            $this->validate($request, [
                'employee_id' => 'required',
                'type' => 'required'
            ], [
                'employee_id.required' => __('admin/loans.employee_required_error')
            ]);

            $data = [];
            $data['total_loans'] = '0.00';

            $to = $request->input('to');
            $from = $request->input('from');
            $type = $request->input('type');
            $employee_id = $request->input('employee_id');

            $to_nice_date = Carbon::createFromFormat('m/d/Y', $to)->toDateString();
            $from_nice_date = Carbon::createFromFormat('m/d/Y', $from)->toDateString();
            
            

            $loanByType = EmployeesLoans::select(DB::raw("SUM(amount) as total_loan"))->where('employee_id', $employee_id)->where('type', $type)->first();

            if(isset($loanByType) && count($loanByType) > 0)
            {
                $data['total_loans'] = number_format($loanByType['total_loan'], 2);
            }


            $qry = EmployeesLoansStatements::query();

            $qry->select(DB::raw("id, datetime, detail, deposit, withdraw"));
            if(isset($employee_id) && $employee_id <> "")
            {
                $qry->where('employee_id', $employee_id);
            }
            else
            {
                $qry->whereDate('datetime', '>=', $to_nice_date)->whereDate('datetime', '<=', $from_nice_date);
            }

            $qry->whereWithdraw(0);

            $loans = $qry->get();

            $data['loans'] = [];
            $pre_loan = $loanByType['total_loan'];

            if(isset($loans) && count($loans) > 0)
            {
                foreach($loans as $loan)
                {

                    $balance = ($pre_loan - $loan['deposit']);

                    $data['loans'][] = [
                        'id' => $loan['id'],
                        'date' => $this->custom->dateformat($loan['datetime']),
                        'detail' => $loan['detail'],
                        'deposit' => $loan['deposit'],
                        'withdraw' => $loan['withdraw'],
                        'balance' => $balance
                    ];

                    $pre_loan = $balance;
                }
            }

           
            $data['to'] = $this->custom->dateformat($to_nice_date);
            $data['from'] = $this->custom->dateformat($from_nice_date);
            $data['employee_id'] = $employee_id;
            $data['type'] = $type;

            $data['employees'] = Employees::where('role', '<>', '1')->where('status', '1')->get();
            return view('admin.employees.loans.statement', $data);

            
        } catch (ModelNotFoundException $e) {
            
        }
    }

}
