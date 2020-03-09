<?php

namespace App\Http\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class AccountsType extends Model
{
    /**
     * Declare Table
     */

    public $table = 'tbl_accounts_types';


    protected $guarded = ['id'];


    public function parent()
    {
        return $this->belongsTo('App\Http\Models\Accounts\AccountsType', 'parent');
    }


    public function children()
    {
        return $this->hasMany('App\Http\Models\Accounts\AccountsType', 'parent');
    }


    public function chartofacc()
    {
        return $this->hasManyThrough('App\Http\Models\Accounts\AccountsChart', 'App\Http\Models\Accounts\AccountsType', 'id', 'type_id')->select(array(
            'tbl_accounts_chart.type_id', 
            'tbl_accounts_chart.name', 
            'tbl_accounts_chart.code', 
            'tbl_accounts_chart.id as cid',
            'tbl_accounts_chart.is_systemize', 
            'tbl_accounts_chart.balance_type', 
            'tbl_accounts_chart.opening_balance', 
        ));
    }


    
    
}
