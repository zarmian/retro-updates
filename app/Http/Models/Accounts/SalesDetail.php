<?php

namespace App\Http\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    /**
     * Declare Table
     */

    public $table = 'tbl_sales_detail';

    public function products()
    {
    	return $this->belongsTo('App\Http\Models\Accounts\Product', 'product');
    }
    public function details()
    {
    	return $this->belongTo('App\Http\Models\Accounts\Sales', 'sale_id');
    }
    public function trucks()
    {
    	return $this->belongTo('App\Http\Models\Accounts\Trucks', 'truck');
    }
}
