<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class EmployeesQualification extends Model
{
    /**
     * Declaring Table
     */

    public $table = 'tbl_employees_qualifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['employee_id', 'degree_name', 'year', 'total_marks', 'obtain_marks', 'grade', 'institute'];


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    public function employee()
    {
        return $this->belongsToMany('App\Http\Models\Admin\Employees');
    }


    public function eCountry(){
        return $this->belongsTo('App\Http\Models\Employees\Countries', 'institute_country');
    }
}
