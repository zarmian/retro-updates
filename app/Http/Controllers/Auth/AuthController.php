<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Auth\AuthModel;
use App\Http\Models\Auth\LoginAttempt;
use Session;

class AuthController extends Controller
{


    protected $guard = 'auth';

    public function showLoginForm(){

    	if(Auth::guard($this->guard)->check()){
    		return redirect('/');
    	}
    	return view('auth.login');
    }


    public function login(Request $request){

    	$this->validateLogin($request);
    	$credentials = $this->getCredentials($request);

    	if(Auth::guard($this->getGuard())->attempt($credentials)){
            return $this->handleUserWasAuthenticated($request);
    	}else{
            return $this->sendFailedLoginResponse($request);
    	}
    }


    protected function validateLogin(Request $request){

    	$this->validate($request, [
    		$this->loginUsername() => 'required',
    		'password' => 'required'
    	]);
    }


    protected function loginUsername(){
    	return property_exists($this,'username') ? $this->username : 'username';
    }


    protected function getGuard(){
    	return property_exists($this, 'guard') ? $this->guard : null;
    }


    protected function getCredentials(Request $request){
        
    	$credentials = array(
    		 'username' => $request->input('username'),
    		 'password' => $request->input('password'),
             'status' => '1'
    	);

    	return $credentials;
    }


    protected function sendFailedLoginResponse(Request $request){

        $ip = $request->ip();

        $employee = new Loginattempt;
        $employee->username = $request->input($this->loginUsername());

        $employee->ip_address = $ip;
        $employee->time = time();

        $employee->save();

        Session::flash('invalid', $this->getFailedLoginMessage()); 

        return view('auth.login');
    }

    protected function getFailedLoginMessage()
    {
        return 'Invalid login details or inactive / unverified account!';
    }


    protected function handleUserWasAuthenticated(Request $request){

        AuthModel::where('id', Auth::guard($this->getGuard())->user()->id)->update(array('last_login_time'=>date('Y-m-d H:i:s')));
        return redirect('/');
    }


    public function logout(){
        Auth::guard($this->guard)->logout();
        return redirect('login');
    }

}
