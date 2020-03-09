<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class InstallerMiddleware
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

        $step = $request->get('step');
        if($step > 3 || $step == 'verfiy' || $step == 'finish' || $step == 'exit')
        {

            $username = $request->session()->get('purchase_key.username');
            $purchase_key = $request->session()->get('purchase_key.verfiy_key');

            if($username == '' || $purchase_key == '')
            {

               return redirect('install?step=3')->with('error', 'Something went wrong.')->with('order_value', 'a'); 
               die;
            }

            $verify = $this->verfiyPurchaseCode();
            if($verify)
            {
                return redirect('install?step=3')->with('error', 'Something went wrong.')->with('order_value', 'a'); 
               die;
            }
            
        }
       
        
        return $next($request);
    }


    public function verfiyPurchaseCode()
    {

        $username = Session()->get('purchase_key.username');
        $verfiy_key = Session()->get('purchase_key.verfiy_key');
        return false;
        die; 

         
    }

}
