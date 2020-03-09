<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class EmployeesOfficialLeave extends Model
{

	/**
     * Declaring Table Name
     */
    public $table = 'tbl_employees_official_leaves';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['title'];


    public function leaveDates(){
        return $this->belongsToMany('App\Http\Models\Admin\EmployeesOfficialLeaveDates', 'tbl_employees_official_leaves_dates', 'leave_id');
    }

    
}
