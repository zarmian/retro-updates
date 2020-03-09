<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class EmployeesLeavesRequest extends Model
{
    /**
     * Declaring Table
     */
    public $table = 'tbl_employees_leaves';



    public function employee()
	{
	    return $this->hasOne('App\Http\Models\Admin\Employees', 'id', 'employee_id');
	}
}
