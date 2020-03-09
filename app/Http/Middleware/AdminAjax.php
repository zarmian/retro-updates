<?php

namespace App\Http\Middleware;

use Closure;

class AdminAjax
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

         if ($request->ajax()) {
            $routeAction = $request->route()->getAction();
            $routeAction['uses'] = str_replace("@index", "@ajax", $routeAction['uses']);
            $routeAction['controller'] = str_replace("@index", "@ajax", $routeAction['controller']);
            $request->route()->setAction($routeAction);
        }
        return $next($request);
    }
}
