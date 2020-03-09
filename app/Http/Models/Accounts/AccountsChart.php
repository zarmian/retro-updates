<?php

namespace App\Http\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class AccountsChart extends Model
{
    //

    public $table = 'tbl_accounts_chart';

    public function type(){
        return $this->hasOne('App\Http\Models\Accounts\AccountsType', 'id');
    }


    public function balance(){
    	return $this->hasMany('App\Http\Models\Accounts\AccountsSummeryDetail', 'account_id');
    }
    
}
