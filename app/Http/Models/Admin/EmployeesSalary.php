<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class EmployeesSalary extends Model
{
    /**
     * Declear Table
     */

    public $table = 'tbl_employees_salary';

    public function employee()
    {
        return $this->hasOne('App\Http\Models\Admin\Employees', 'id', 'employee_id');
    }
}
