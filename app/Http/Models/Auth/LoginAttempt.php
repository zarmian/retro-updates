<?php

namespace App\Http\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{

	/**
     * Declaring Table Name
     */

    public $table = 'tbl_employees_login_attempt';

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
