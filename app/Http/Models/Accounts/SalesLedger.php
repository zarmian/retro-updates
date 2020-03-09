<?php

namespace App\Http\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class SalesLedger extends Model
{
    /**
     * Declare Table
     */

    public $table = 'tbl_sales_ledger';

    public function account()
    {
    	return $this->belongsTo('App\Http\Models\Accounts\AccountsChart', 'account_id');
    }
}
