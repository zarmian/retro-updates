<?php

namespace App\Http\Models\Accounts;
use Illuminate\Database\Eloquent\Model;

class TruckDetail extends Model
{
    //
    public $table = 'tbl_truck_detail';


    public $timestamps = false;

    public function trucks()
    {
    	return $this->belongsTo('App\Http\Models\Accounts\Trucks','truck_id');
    }
    public function products()
    {
    	return $this->belongsTo('App\Http\Models\Accounts\Product','product_id');
    }
}
