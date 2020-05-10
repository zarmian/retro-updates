<?php

namespace App\Http\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    public $table = 'tbl_payment';
    public $timestamps = false;
    public function account()
    {
        return $this->belongsTo('App\Http\Models\Accounts\AccountsChart', 'account_id', 'id');
    }
}
