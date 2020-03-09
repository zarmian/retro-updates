<?php

namespace App\Http\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class AuthRole extends Model
{

	/**
     * Declaring Table Name
     */

    public $table = 'tbl_employees_roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
    	'id',
    	'name',
    	'description',
    	'permissions'
   	];
    

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
   	public $timestamps = false;

  
}
