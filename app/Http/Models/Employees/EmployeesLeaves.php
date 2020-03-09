<?php

namespace App\Http\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class EmployeesLeaves extends Model
{
    /**
   	  * declaring table
   	*/

   	public $table = 'tbl_employees_leaves';


   	public function leaveDates(){

   		return $this->belongsToMany('App\Http\Models\Employees\EmployeesLeavesDates', 'tbl_employees_leaves_dates', 'leave_id');
   	}
}
