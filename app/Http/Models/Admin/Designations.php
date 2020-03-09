<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Designations extends Model
{
    /**
   	  * declaring table
   	*/

   	public $table = 'tbl_designations';


   	/**
     * The attributes that should be fillable for arrays.
     *
     * @var array
     */

   	protected $fillable = [
    	'title',
    	'status',
    ];


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
