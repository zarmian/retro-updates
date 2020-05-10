<?php

namespace App\Http\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class Trucks extends Model
{
    //

    public $table = 'tbl_products';


    public $timestamps = false;

    public function details()
    {
    	return $this->hasMany('App\Http\Models\Accounts\TruckDetail', 'truck_id');
    }
    public function trucks()
    {
    	return $this->hasMany('App\Http\Models\Accounts\PurchaseDetail', 'title');
    }
    public function truck()
    {
    	return $this->hasMany('App\Http\Models\Accounts\SalesDetail', 'title');
    }

  
    
}
