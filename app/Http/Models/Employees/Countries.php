<?php

namespace App\Http\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    /**
   	 * Declaring table
   	 */

   	public $table = "tbl_countries";

   	public function countries(){
        return $this->belongsTo('App\Http\Models\Employees\EmployeesAuth', 'nationality');
    }
}
