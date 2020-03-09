<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class EmployeesOfficialLeaveDates extends Model
{
    /**
     * Declaring Table Name
     */
    public $table = 'tbl_employees_official_leaves_dates';

    /**
     * The primary key associated with the parent table.
     *
     * @var int
     */
    protected $primaryKey = 'leave_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['leave_date'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */

    public $timestamps = false;


    public function title()
    {
        return $this->belongsTo('App\Http\Models\Admin\EmployeesOfficialLeave', 'leave_id');
    }
}
