<?php

namespace App\Http\Middleware;

use App\Http\Models\Auth\LoginAttempt;
use Illuminate\Http\Request;
use Closure;
use DB;

class LoginAttemptVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        

        $max_login_attempt = config('io_auth.max_attempt');
        $lockout_time = floor(config('io_auth.lockout_time') / 60 % 60);

        
        if($this->is_time_locked_out($request)){

            return redirect()->back()->with('error', 'You have '.$max_login_attempt.' failed login attempts. Please try after '.$lockout_time.' minutes');
        }

        $this->clear_login_attempts($request);
        
        return $next($request);
    }


    protected function is_time_locked_out(Request $request){

        return $this->is_max_login_attempts_exceeded($request) && $this->get_last_attempt_time($request) > time() - config('io_auth.lockout_time');

    }


    protected function is_max_login_attempts_exceeded(Request $request){

        $max_login_attempt = config('io_auth.max_attempt');
        if($max_login_attempt > 0){
            $attempts = $this->get_attempts_num($request);
            return $attempts >= $max_login_attempt;
        }

    }


    protected function get_attempts_num(Request $request){

        $ip_address =  $request->ip();
        $obj = DB::table('tbl_employees_login_attempt');
        $obj->select('1', TRUE);
        $obj->where('ip_address', $ip_address);
        $obj->where('username', $request->input('username'));
        return $obj->count();
    }


    protected function get_last_attempt_time(Request $request){

        $ip_address = $request->ip();
        $attempt = LoginAttempt::select(DB::raw('MAX(time) as time'))->where('ip_address', $ip_address)->first();

        return $attempt->time;
    }


    protected function clear_login_attempts(Request $request){

        $time_period = 54000;
        $obj = LoginAttempt::where('ip_address', $request->ip())->where('time', '<', time() - $time_period);

        $obj->delete();
    }
}
