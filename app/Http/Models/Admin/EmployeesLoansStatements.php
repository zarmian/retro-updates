<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class EmployeesLoansStatements extends Model
{
    /**
     * Declaring Table
     */

    public $table = 'tbl_employees_loans_statements';

    public function employees_loan()
    {
        return $this->belongsTo('App\Http\Models\Admin\Employees', 'id');
    }
}
