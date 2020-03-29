<?php

namespace App\Http\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    public $table = 'tbl_items';
    public $timestamps = false;

    public function details()
    {
    	return $this->hasMany('App\Http\Models\Accounts\TruckDetail', 'product_id');
    }

    public function sale_details()
    {
    	return $this->hasMany('App\Http\Models\Accounts\SalesDetail', 'product');
    }
    public function purchase_details()
    {
    	return $this->hasMany('App\Http\Models\Accounts\PurchaseDetail', 'product');
    }
}
