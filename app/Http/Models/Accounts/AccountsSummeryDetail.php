<?php

namespace App\Http\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class AccountsSummeryDetail extends Model
{
    /**
     * Declare Table
     */

    public $table = 'tbl_accounts_summery_detail';

    public function details()
    {
    	return $this->hasOne('App\Http\Models\Accounts\AccountsSummery', 'id', 'summery_id');
    }

    public function account()
    {
        return $this->belongsTo('App\Http\Models\Accounts\AccountsChart', 'account_id', 'id');
    }
}
