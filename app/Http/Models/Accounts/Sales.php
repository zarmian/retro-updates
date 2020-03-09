<?php

namespace App\Http\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    /**
     * Declare Table
     */

    public $table = 'tbl_sales';


    public function customer()
    {
    	return $this->belongsTo('App\Http\Models\Accounts\Customers', 'customer_id');
    }


    public function details()
    {
    	return $this->hasMany('App\Http\Models\Accounts\SalesDetail', 'sale_id');
    }


    public function paid()
    {
        return $this->hasMany('App\Http\Models\Accounts\SalesLedger', 'sale_id');
    }
}
