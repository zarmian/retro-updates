<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{

	/**
     * Declaring Table Name
     */

    public $table = 'tbl_users_permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
    	'name',
    	'title',
   	];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    
	public $timestamps = false;
}
