<?php

namespace App\Http\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class EmployeesLoginAttempt extends Model
{
    /**
   	 * Declaring table
   	 */

   	public $table = "tbl_employees_login_attempt";

   	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */

   	protected $fillable = [
   		'ip_address',
   		'time'
   	];
}
