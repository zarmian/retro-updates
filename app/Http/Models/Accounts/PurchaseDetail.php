<?php

namespace App\Http\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    
    /**
     * Declare Table
     */

    public $table = 'tbl_purchase_detail';
    public function products()
    {
    	return $this->belongsTo('App\Http\Models\Accounts\Product', 'product');
    }
    public function details1()
    {
    	return $this->belongTo('App\Http\Models\Accounts\Purchase', 'sale_id');
    }
    public function trucks()
    {
    	return $this->belongTo('App\Http\Models\Accounts\Trucks', 'title');
    }
    public function destination()
    {
    	return $this->belongTo('App\Http\Models\Accounts\Destination', 'destination');
    }

}
