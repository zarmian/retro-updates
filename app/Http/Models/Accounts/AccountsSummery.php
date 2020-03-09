<?php

namespace App\Http\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class AccountsSummery extends Model
{
    /**
     * Declare Table
     */

    public $table = 'tbl_accounts_summery';


    public function amount()
    {
    	return $this->hasMany('App\Http\Models\Accounts\AccountsSummeryDetail', 'summery_id');
    }


    public function details()
    {
    	return $this->hasMany('App\Http\Models\Accounts\AccountsSummeryDetail', 'summery_id');
    }


    
}
