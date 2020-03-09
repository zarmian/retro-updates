<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Employees\LoansRequest;
use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Employees;
use Illuminate\Http\Request;
use App\Libraries\Customlib;
use Carbon\Carbon;
use Auth;

class EmployeesLoansRequest extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            $employee_id = Auth::guard('auth')->user()->id;

            $data['loans'] = LoansRequest::where('employee_id', $employee_id)->paginate($data['per_page']);

            return view('employees.loans.index', $data);
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
            return view('employees.loans.create');
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
                'title' => 'required',
                'date' => 'required',
                'amount' => 'required|numeric|between:0,1000000'
            ]);

            $date = Carbon::createFromFormat('m/d/Y', $request->input('date'))->toDateString();

            $employee_id = Auth::guard('auth')->user()->id;

            $loan = new LoansRequest;
            $loan->employee_id = $employee_id;
            $loan->datetime = $date;
            $loan->title = $request->input('title');
            $loan->detail = $request->input('reason');
            $loan->amount = $request->input('amount');
            $loan->status = '0';
            $loan->added_by = $employee_id;
            $loan->save();

            if($loan){

                $enable_email = $this->custom->getSetting('ENABLE_EMAIL');
                if(isset($enable_email) && $enable_email == 'true')
                {
                    $template = $this->custom->getTemplate(8);
                    if(isset($template['status']) && $template['status'] == 1)
                    {

                        $employee = Employees::select('id', 'first_name', 'last_name', 'email')->first();
                        
                        $var = array('{first_name}', '{last_name}', '{loan_date}', '{loan_amount}', '{business_name}');
                        $val = array($employee->first_name, $employee->last_name, $this->custom->dateformat($date), number_format($request->input('amount'), 2), $this->custom->getSetting('BUSINESS_NAME'));
                        $template_cotent = str_replace($var, $val, $template['content']);
                        $template = $this->custom->basic_email($this->custom->getSetting('BUSINESS_EMAIL'), $template['subject'], $template_cotent);
                    }

                }

                $request->session()->flash('msg', __('employees/common.new_entry_txt'));
            }

            return redirect('/loan-request/create');
        } catch (ModelNotFoundException $e) {
            return redirect('/loan-request/create');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Employees\LoansRequest  $loansRequest
     * @return \Illuminate\Http\Response
     */
    public function show($id = NULL)
    {

        try {

           if(is_null($id)) return redirect('/loan-request');

           $data['loan'] = [];

           $employee_id = Auth::guard('auth')->user()->id;

           $data['loan'] = LoansRequest::where('employee_id', $employee_id)->find($id);
           return view('employees.loans.view', $data);
            
        } catch (ModelNotFoundException $e) {
            return redirect('/loan-request');
        }
        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Employees\LoansRequest  $loansRequest
     * @return \Illuminate\Http\Response
     */
    public function edit($id = NULL)
    {
        try {

            if(is_null($id)) return redirect('/loan-request');

            $data['loan'] = LoansRequest::findOrFail($id);

            return view('employees.loans.edit', $data);

        } catch (ModelNotFoundException $e) {

            return redirect('/loan-request');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Employees\LoansRequest  $loansRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = NULL)
    {
        try {

            if(is_null($id)) return redirect('/loan-request');

            $this->validate($request, [
                'title' => 'required',
                'date' => 'required',
                'amount' => 'required|numeric|between:0,1000000'
            ]);

            $date = Carbon::createFromFormat('m/d/Y', $request->input('date'))->toDateString();

            $loan = LoansRequest::findOrFail($id);
            $loan->datetime = $date;
            $loan->title = $request->input('title');
            $loan->detail = $request->input('reason');
            $loan->amount = $request->input('amount');
            $loan->save();

            if($loan){
                $request->session()->flash('msg', __('employees/common.update_entry_txt'));
            }

            return redirect('/loan-request/edit/'.$id);

        } catch (ModelNotFoundException $e) {
            return redirect('/loan-request');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Models\Employees\LoansRequest  $loansRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy($id = NULL)
    {
        try {
            
            if(is_null($id)) return redirect('/loan-request');
            $loan = LoansRequest::findOrFail($id);
            $loan->delete();

            if($loan){
                session()->flash('msg', __('employees/common.delete_entry_txt'));
            }

            return redirect('/loan-request');

        } catch (ModelNotFoundException $e) {
            return redirect('/loan-request');
        }
    }
}
