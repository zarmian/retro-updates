<?php

namespace App\Http\Models\Auth;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AuthModel extends Authenticatable
{
    use Notifiable;

    /**
     * declaring table
     */
      
    public $table = 'tbl_employees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_code',
        'first_name',
        'last_name',
        'fathers_name',
        'mothers_name',
        'username',
        'password',
        'email',
        'gender',
        'maritial_status',
        'national_id',
        'present_address',
        'permanant_address',
        'mobile_no',
        'phone_no',
        'date_of_birth',
        'joining_date',
        'leaving_date',
        'department_id',
        'designation_id',
        'shift_id',
        'employee_type',
        'role',
        'salary_type',
        'basic_salary',
        'accomodation_allowance',
        'medical_allowance',
        'house_rent_allowance',
        'transportation_allowance',
        'food_allowance',
        'overtime_1',
        'overtime_2',
        'overtime_3',
        'status',
        'avatar',
        'reference',
        'remember_token',
        'create_by',
        'create_ip'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password'];
    
    

    /**
     * making relationship with users table
     */

    // public function designation(){
    //     return $this->belongsTo('App\Http\Models\Auth\AuthRole', 'role');
    // }


    public function roles()
    {
        return $this->belongsTo('App\Http\Models\Auth\AuthRole', 'role');
    }


    public function hasAnyRole($roles)
    {

 
    }


    public function hasRole($role)
    {
        $role_id = $this->roles->id;
        $permissions = $this->roles()->where('id', $role_id)->first()->permissions;
        $unserialize = unserialize($permissions);
        if(isset($unserialize) && count($unserialize) > 0)
        {
            foreach($unserialize as $key=>$val)
            {
                if(isset($unserialize[$role]) && $unserialize[$role] == 'true'){
                    return true;
                }
                return false;
            }
        }
    }


    
}
