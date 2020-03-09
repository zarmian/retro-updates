<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class EmployeesWorkExperience extends Model
{
    /**
     * Declaring Table
     */

    public $table = 'tbl_employees_work_experience';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['employee_id', 'job_title', 'company_name', 'country_name', 'city_name', 'start_date', 'end_date', 'current_status'];


}