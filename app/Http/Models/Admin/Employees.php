<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Employees extends Model
{

    /**
     * Declaring Table
     */

    public $table = 'tbl_employees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
    	'employee_code',
    	'first_name',
    	'last_name',
    	'fathers_name',
    	'mothers_name',
    	'username',
    	'password',
    	'email',
    	'gender',
    	'marital_status',
    	'national_id',
    	'present_address',
    	'permanant_address',
    	'mobile_no',
    	'phone_no',
    	'date_of_birth',
    	'joining_date',
    	'leaving_date',
    	'department_id',
    	'designation_id',
    	'shift_id',
    	'employee_type',
    	'role',
    	'salary_type',
    	'basic_salary',
    	'accomodation_allowance',
    	'medical_allowance',
    	'house_rent_allowance',
    	'transportation_allowance',
    	'food_allowance',
    	'overtime_1',
    	'overtime_2',
    	'overtime_3',
    	'status',
    	'avatar',
    	'reference',
    	'remember_token',
    	'create_by',
    	'create_ip'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password'];

    
    /**
     * @return String
     */
    public function fullName(){
        return $this->first_name.' '.$this->last_name;
    }


    public function department(){
        return $this->hasOne('App\Http\Models\Admin\Departments', 'id', 'department_id');
    }


    public function designation(){
        return $this->belongsTo('App\Http\Models\Admin\Designations', 'designation_id');
    }


    public function sum_salary(){

        return $this->basic_salary + $this->accomodation_allowance + $this->medical_allowance + $this->house_rent_allowance + $this->transportation_allowance + $this->food_allowance;
    }


    public function convertdate($date=''){
        return date('m-d-Y', strtotime($date));
    }
    

    public function employeesq()
    {
        return $this->belongsToMany('App\Http\Models\Admin\EmployeesQualification', 'tbl_employees_qualifications', 'employee_id');
    }

    public function employees_work()
    {
        return $this->belongsToMany('App\Http\Models\Admin\EmployeesWorkExperience', 'tbl_employees_work_experience', 'employee_id');
    }


    public function loan_statements()
    {
        return $this->hasOne('App\Http\Models\Admin\EmployeesLoansStatements', 'employee_id');
    }


    public function shift()
    {
        return $this->belongsTo('App\Http\Models\Admin\Shift', 'shift_id', 'id');
    }


    public function countries(){
        return $this->hasOne('App\Http\Models\Employees\Countries', 'id', 'nationality');
    }


    public function genders(){
        return $this->hasOne('App\Http\Models\Employees\Genders', 'id', 'gender');
    }


    public function present()
    {
        return $this->hasOne('App\Http\Models\Employees\EmployeesAttendance', 'employee_id');
    }

    public function roles(){
        return $this->belongsTo('App\Http\Models\Auth\AuthRole', 'role');
    }

   
}
