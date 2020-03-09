<?php

namespace App\Http\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    /**
     * Declare Table
     */

    public $table = 'tbl_customers';


    public function country()
    {
    	return $this->hasOne('App\Http\Models\Employees\Countries', 'id', 'country_id');
    }


    public function sales()
    {
    	return $this->hasMany('App\Http\Models\Accounts\Sales', 'customer_id');
    }


    public function ledger()
    {
    	return $this->hasMany('App\Http\Models\Accounts\SalesLedger', 'customer_id');
    }

   
}
