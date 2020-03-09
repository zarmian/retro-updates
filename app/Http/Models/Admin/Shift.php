<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{

	/**
     * Declaring Table Name
     */

    public $table = 'tbl_shift';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
    	'title',
    	'start_time',
    	'end_time'
   	];


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */

    public $timestamps = false;

    
}
