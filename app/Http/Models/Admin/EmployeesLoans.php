<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class EmployeesLoans extends Model
{
    
    /**
     * Declaring Table
     */
    public $table = 'tbl_employees_loans';


    /**
     * Declaring primary key
     * @var int
     */
    protected $primaryKey = "employee_id";


    public function employee()
	{
	    return $this->hasOne('App\Http\Models\Admin\Employees', 'id', 'employee_id');
	}


}
