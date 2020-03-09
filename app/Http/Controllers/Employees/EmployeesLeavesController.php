<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Employees\EmployeesLeaves;
use App\Http\Models\Employees\EmployeesLeavesDates;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Admin\Employees;
use App\Http\Models\Employees\LeaveCategory;
use App\Libraries\Customlib;
use DateInterval;
use DatePeriod;
use DateTime;
use Auth;

class EmployeesLeavesController extends Controller
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

            $childrens = [];
            $data['per_page'] = \Request::get('per_page') ?: 12;

            $employee_id = Auth::guard('auth')->user()->id;
            $leaves = EmployeesLeaves::where('employee_id', $employee_id)->paginate($data['per_page']);

            foreach($leaves as $leave):

                $child = [];
                $childrens = EmployeesLeavesDates::where('leave_id', $leave->id)->get();
                foreach($childrens as $children):
                    $child[] = $children->leave_date;
                endforeach;

                $data['leaves'][] = [
                    'id' => $leave->id,
                    'title' => $leave->title,
                    'status' => $leave->status,
                    'leave_date' => $child,
                ];

            endforeach;

            $data['pages'] = $leaves->appends(\Input::except('page'))->render();

            return view('employees.leaves.index', $data);
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
         //   $employees = Employees::all();
            $employees = \DB::table('tbl_employees')->where('status', '=', '1')->where('role', '=', '5')->get();
            $leave_category = \DB::table('tbl_leave_category')->get();

            foreach($employees as $list_employee):
                $employee_list['list'] [] = ['id' =>$list_employee->id,
                    'first_name' => $list_employee->first_name,
                    'last_name' => $list_employee->last_name,];
            endforeach;

            foreach($leave_category as $list_category):
                $category_leave['list_cat'] [] = ['id' =>$list_category->id,
                    'category_name' => $list_category->category_name,
                    'leave_quantity' => $list_category->leave_quantity,];
            endforeach;


            return view('employees.leaves.create',  $employee_list, $category_leave);
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
                'start_date' => 'required',
                'end_date' => 'required'
            ]);

            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');

            $employee_id = Auth::guard('auth')->user()->id;

            $leave = new EmployeesLeaves;
            $leave->employee_id = $request->input('employee_id');
            $leave->title = $request->input('title');
            $leave->status = '0';
            $leave->description = $request->input('description');
            $leave->create_by = $request->input('employee_id');
            $leave->cat_id = $request->input('cat_id');
            $leave->save();

            if($leave->id){

                $begin = new DateTime($start_date);
                $end = new DateTime($end_date);
                $modiy = $end->modify( '+1 day' );
                $interval = new DateInterval('P1D');
                $daterange = new DatePeriod($begin, $interval ,$modiy);

                $r=0;

                foreach($daterange as $date){

                    $dates = new EmployeesLeavesDates;
                    $dates->leave_id = $leave->id;
                    $dates->leave_date = $date->format("Y-m-d");
                    $dates->emp_id = $request->input('employee_id');
                    $dates->leave_cat_id = $request->input('cat_id');
                    $dates->status = '0';
                    $dates->save();
                    $r++;

                }

                $enable_email = $this->custom->getSetting('ENABLE_EMAIL');
                if(isset($enable_email) && $enable_email == 'true')
                {
                    $template = $this->custom->getTemplate(14);

                    if(isset($template['status']) && $template['status'] == 1)
                    {
                      
                        $employee = Employees::select('first_name', 'last_name')->find($employee_id);

                        $var = array('{first_name}', '{last_name}', '{title}', '{leave_start_date}', '{leave_end_date}', '{leave_total_days}', '{description}', '{business_name}');
                        $val = array($employee->first_name, $employee->last_name, $request->input('title'), $this->custom->dateformat($begin->format("Y-m-d")), $this->custom->dateformat($end->format("Y-m-d")), $r, $request->input('description'), $this->custom->getSetting('BUSINESS_NAME'));
                        $template_cotent = str_replace($var, $val, $template['content']);

                        $template = $this->custom->basic_email($this->custom->getSetting('BUSINESS_EMAIL'), $template['subject'], $template_cotent);
                    }

                }

                $request->session()->flash('msg', __('employees/common.new_entry_txt'));
                return redirect('/leave-request/create');
            }
            
        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

           if(is_null($id)) return redirect('/leave-request');

           $data['leave'] = [];

           $employee_id = Auth::guard('auth')->user()->id;

           $data['leave'] = EmployeesLeaves::where('employee_id', $employee_id)->find($id);

           return view('employees.leaves.view', $data);
            
        } catch (ModelNotFoundException $e) {
             return redirect('/leave-request');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = NULL)
    {

        try {

            if(is_null($id)) return redirect('/leave-request');

            $data['leave'] = EmployeesLeaves::findOrFail($id);

            $data['start_date'] = EmployeesLeavesDates::select('leave_date')->where('leave_id', $data['leave']->id)->orderBy('id', 'asc')->first();

            $data['end_date'] = EmployeesLeavesDates::select('leave_date')->where('leave_id', $data['leave']->id)->orderBy('id', 'desc')->first();

            return view('employees.leaves.edit', $data);

        } catch (ModelNotFoundException $e) {
            return redirect('employees/leave-request');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = NULL)
    {
        try {

            if(is_null($id)) return redirect('/leave-request');
            $this->validate($request, [
                'title' => 'required',
                'start_date' => 'required',
                'end_date' => 'required'
            ]);


            $leave = EmployeesLeaves::findOrFail($id);

            $leave->title = $request->input('title');
            $leave->description = $request->input('description');
            $leave->save();

            if($leave){

                $leave->leaveDates()->detach();

                $begin = new DateTime($request->input('start_date'));
                $end = new DateTime($request->input('end_date'));
                $end = $end->modify( '+1 day' );
                $interval = new DateInterval('P1D');
                $daterange = new DatePeriod($begin, $interval ,$end);
                foreach($daterange as $date){

                    $dates = new EmployeesLeavesDates;
                    $dates->leave_id = $leave->id;
                    $dates->leave_date = $date->format("Y-m-d");
                    $dates->save();
                }
            }

            $request->session()->flash('msg', __('employees/common.new_entry_txt'));
            return redirect('/leave-request/edit/'.$id);

        } catch (ModelNotFoundException $e) {
            return redirect('/leave-request');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id = NULL)
    {
        try {

            if(is_null($id)) return redirect('/leave-request');
            
            $result = EmployeesLeaves::destroy($id);
            if($result){
                session()->flash('msg', __('employees/common.remove_entry_txt'));
            }
            return redirect('/leave-request/');
            
        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function manage_all_leaves(){

        try {
            //   $employees = Employees::all();
            $employees = \DB::table('tbl_employees')->where('status', '=', '1')->where('role', '=', '5')->get();
            $leave_category = \DB::table('tbl_leave_category')->get();
            $data['per_page'] = \Request::get('per_page') ?: 12;

            foreach($employees as $list_employee):
                $employee_list['list'] [] = ['id' =>$list_employee->id,
                    'first_name' => $list_employee->first_name,
                    'last_name' => $list_employee->last_name,];
            endforeach;

            foreach($leave_category as $list_category):
                $category_leave['list_cat'] [] = ['id' =>$list_category->id,
                    'category_name' => $list_category->category_name,
                    'leave_quantity' => $list_category->leave_quantity,];
            endforeach;


            return view('employees.leaves.manage_all_leaves', $employee_list, $category_leave, $data);
        } catch (ModelNotFoundException $e) {

        }

    }

    public function store_leave(Request $request){

     $this->store($request);

        $request->session()->flash('msg', __('employees/common.new_entry_txt'));
        return redirect('/manage-all-leaves');
    }

    public function getPendingLeaves(Request $request)
    {
        try {

            $data =  ['status' => '0'];

            $employee_id = $request->get('employee_id');
            $leave_type = $request->get('leave_type');

            if($employee_id <> "" && $leave_type <> "")
            {
                $CountLeaves = EmployeesLeavesDates::where('emp_id', $employee_id)->where('leave_cat_id', $leave_type)->where('status', '1')->count();

                $row = LeaveCategory::where('id', $leave_type)->first();

                $data =  [
                    'status' => '1',
                    'count_leaves' => $CountLeaves,
                    'leave_name' => $row->category_name,
                    'leave_quantity' => $row->leave_quantity,
                    'reaming_leaves' => $row->leave_quantity - $CountLeaves,
                ];
            }

            return response()->json($data);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                    'status' => '0'
            ]);
        }
    }

}
