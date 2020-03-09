<?php

namespace App\Http\Models\Employees;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EmployeesAuth extends Authenticatable
{
    use Notifiable;

   	/**
   	 * Declaring table
   	 */

   	public $table = "tbl_employees";

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
    	'maritial_status',
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


    public function department(){
        return $this->belongsTo('App\Http\Models\Employees\EmployeesDepartments');
    }

    public function genders(){
        return $this->belongsTo('App\Http\Models\Employees\Genders', 'gender');
    }

    public function countries(){
        return $this->hasOne('App\Http\Models\Employees\Countries', 'id', 'nationality');
    }


    public function shift(){
        return $this->belongsTo('App\Http\Models\Admin\Shift', 'shift_id');
    }

    
}
