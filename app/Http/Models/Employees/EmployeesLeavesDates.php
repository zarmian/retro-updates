<?php

namespace App\Http\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class EmployeesLeavesDates extends Model
{
    /**
   	  * declaring table
   	*/

   	public $table = 'tbl_employees_leaves_dates';

   	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */

    public $timestamps = false;


    public function title()
    {
        return $this->belongsTo('App\Http\Models\Employees\EmployeesLeaves', 'leave_id');
    }
}
