<?php

namespace App\Http\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    /**
     * Declare Table
     */

    public $table = 'tbl_vendors';


   public function country()
    {
    	return $this->hasOne('App\Http\Models\Employees\Countries', 'id', 'country_id');
    }


    public function sales()
    {
    	return $this->hasMany('App\Http\Models\Accounts\Purchase', 'vendor_id');
    }


    public function ledger()
    {
    	return $this->hasMany('App\Http\Models\Accounts\PurchaseLedger', 'vendor_id');
    }
}
