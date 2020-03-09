<?php

namespace App\Http\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class PurchaseLedger extends Model
{
    /**
     * Declare Table
     */

    public $table = 'tbl_purchase_ledger';


    public function account()
    {
    	return $this->belongsTo('App\Http\Models\Accounts\AccountsChart', 'account_id');
    }
}
