<?php

namespace App\Http\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    /**
     * Declare Table
     */

    public $table = 'tbl_purchase';


     public function vendor()
    {
    	return $this->belongsTo('App\Http\Models\Accounts\Vendors', 'vendor_id');
    }



    public function details()
    {
    	return $this->hasMany('App\Http\Models\Accounts\PurchaseDetail', 'sale_id');
    }


    public function paid()
    {
        return $this->hasMany('App\Http\Models\Accounts\PurchaseLedger', 'sale_id');
    }
}
