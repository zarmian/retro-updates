<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class EmployeesPermissions extends Model
{
    /**
     * Declaring Table
     */

    public $table = 'tbl_employees_permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['title', 'name'];


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
