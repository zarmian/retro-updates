<?php
namespace App\Http\Middleware;

use App\Http\Models\Auth\AuthRole;
use Closure;
use Auth;
use DB;
use Redirect;


class UserRolePermissions
{

    protected $permissions = array();
    protected $guard = 'auth';

    const DELIMITER = '|';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions)
    {

        $this->permissions();
        $get_access = $this->get_user_access($permissions);
        
        if($get_access == 0){
            abort('404');
        }
      
        return $next($request);
    }


    protected function get_user_access($permissions){

        if($permissions==''){ return true; }

        $permissions = explode(self::DELIMITER ,$permissions);
        $allowed = false;
        foreach($permissions as $permission){

            if(isset($this->permissions[$permission]) && $this->permissions[$permission] == true){
                $allowed = true;
                break;
            }
        }

        return $allowed;

    }


    protected function permissions(){

        $gid = Auth::guard($this->guard)->user()->role;
        $row = AuthRole::find($gid);
        $this->permissions = unserialize($row->permissions);
    }
}
