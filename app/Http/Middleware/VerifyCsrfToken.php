<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {


	private $openRoutes = [
		'profile/ajax',
		'profile/cover', 
		'employees/profile/ajax', 
		'employees/profile/cover',
		'setting/logo'
	];
   

    //modify this function
	public function handle($request, Closure $next)
	    {
	        //add this condition 
	    foreach($this->openRoutes as $route) {

	      if ($request->is($route)) {
	        return $next($request);
	      }
	    }
	    
	    return parent::handle($request, $next);
	  }
   

}