<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Admin\EmployeesOfficialLeaveDates;
use App\Http\Models\Admin\EmployeesOfficialLeave;
use App\Http\Models\Employees\Notifications;
use App\Jobs\OfficialLeavesEmailJob;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Customlib;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Auth;


class EmployeesOfficialLeavesController extends Controller
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

            $qry = EmployeesOfficialLeave::query();
            $qry->select('tbl_employees_official_leaves.id', 'tbl_employees_official_leaves.title');
            

            if(\Request::has('title'))
            {
                $title = \Request::get('title');
                $qry->where('tbl_employees_official_leaves.title', 'LIKE', "%$title%");
            }

            $qry->orderBy('tbl_employees_official_leaves.id', 'desc');
            $leaves = $qry->paginate($data['per_page']);
            
            foreach($leaves as $leave){

                $child = [];
                $childrens = EmployeesOfficialLeaveDates::where('leave_id', $leave->id)->get();
                foreach($childrens as $children){
                    $child[] = $children->leave_date;
                }


                $data['leaves'][] = array(
                    'id' => $leave->id,
                    'title' => $leave->title,
                    'start_from' => $this->custom->dateformat(array_first($child)),
                    'end' =>  $this->custom->dateformat(array_last($child)),
                    'leave_date' => $child
                );
            }

            $data['pages'] = $leaves->appends(\Input::except('page'))->render();
           
            
            return view('admin.employees.leaves.manage', $data);
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
            return view('admin.employees.leaves.create');
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


            $sdate = $request->input('start_date');
            $edate = $request->input('end_date');

            $snice_date = Carbon::createFromFormat('m/d/Y', $sdate)->toDateString();
            $enice_date = Carbon::createFromFormat('m/d/Y', $edate)->toDateString();


            $end = strtotime($enice_date);
            $start = $day = strtotime($snice_date);

            $leave = new EmployeesOfficialLeave;
            $leave->title = $request->input('title');
            $leave->status = $request->input('status');
            $leave->added_by = Auth::guard('auth')->user()->id;
            $leave->save();

            if($leave->id){

                while($day <= $end)
                {

                    $dates = new EmployeesOfficialLeaveDates;
                    $dates->leave_id = $leave->id;
                    $dates->leave_date = date('Y-m-d', $day);
                    $dates->save();

                    $day = strtotime('+1 day', $day);
                }

                $description = "Offical leaves start from ".$this->custom->dateformat($snice_date)." to ".$this->custom->dateformat($enice_date);


                $notice = new Notifications();

                $notice->datetime = date('Y-m-d H:i:s', time());
                $notice->title = $request->input('title');
                $notice->description = $description;
                $notice->type = '1';
                $notice->unread = '1';
                $notice->added_by = Auth::guard('auth')->user()->id;
                $notice->save();

                $enable_email = $this->custom->getSetting('ENABLE_EMAIL');
                if(isset($enable_email) && $enable_email == 'true')
                {
                    $dd = [
                        'title' => $request->input('title'),
                        'sdate' => $this->custom->dateformat($snice_date),
                        'edate' => $this->custom->dateformat($enice_date),
                        'description' => $description,
                    ];

                    $job = (new OfficialLeavesEmailJob($dd))->delay(Carbon::now()->addSeconds(10));
                    dispatch($job);
                }

            }

            
            $request->session()->flash('msg', __('admin/leaves.added_official'));
            return redirect('/official-leaves/create');

        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Admin\EmployeesOfficeLeaves  $employeesOfficeLeave
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeesOfficialLeave $employeesOfficeLeave, $id = NULL)
    {
        try {

            if(is_null($id)){ return redirect('/official-leaves'); }

            $data['leave'] = $employeesOfficeLeave->findOrFail($id);

            $data['start_date'] = EmployeesOfficialLeaveDates::select('leave_date')->where('leave_id', $data['leave']->id)->orderBy('id', 'asc')->first();

            $data['end_date'] = EmployeesOfficialLeaveDates::select('leave_date')->where('leave_id', $data['leave']->id)->orderBy('id', 'desc')->first();


            return view('admin.employees.leaves.edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect('/official-leaves');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Admin\EmployeesOfficeLeaves  $employeesOfficeLeaves
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = NULL)
    {
        try {

            if(is_null($id)){ return redirect('/official-leaves'); }
            
            $this->validate($request, [
                'title' => 'required',
                'start_date' => 'required',
                'end_date' => 'required'
            ]);

            $leave = EmployeesOfficialLeave::findOrFail($id);
            $leave->title = $request->input('title');
            $leave->status = $request->input('status');
            $leave->added_by = Auth::guard('auth')->user()->id;
            $leave->save();

            if($leave->id){

                $leave->leaveDates()->detach();

                $begin = new DateTime($request->input('start_date'));
                $end = new DateTime($request->input('end_date'));
                $end = $end->modify( '+1 day' );
                $interval = new DateInterval('P1D');
                $daterange = new DatePeriod($begin, $interval ,$end);
                foreach($daterange as $date){

                    $dates = new EmployeesOfficialLeaveDates;
                    $dates->leave_id = $leave->id;
                    $dates->leave_date = $date->format("Y-m-d");
                    $dates->save();
                }
            }
            $request->session()->flash('msg', __('admin/leaves.update_official'));
            return redirect('/official-leaves/edit/'.$id);
        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Models\Admin\EmployeesOfficeLeaves  $employeesOfficeLeaves
     * @return \Illuminate\Http\Response
     */
    public function destroy($id = NULL)
    {
        try {
            if(is_null($id)){}
        } catch (ModelNotFoundException $e) {
            
        }
    }
}
