<?php

namespace App\Http\Middleware;
use App\Http\Models\Auth\AuthModel;
use Illuminate\Support\Facades\Auth;
use Closure;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'auth')
    {

        if(!Auth::guard($guard)->check()){
            return redirect('login');
        }

        $result = AuthModel::whereId(Auth::guard($guard)->user()->id)->whereStatus('1')->count();
        
        if($result == 0){
            Auth::guard('auth')->logout();
            return redirect('login');
        }
       
        return $next($request);
    }
}
