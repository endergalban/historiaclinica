<?php

namespace App\Http\Middleware;

use Closure;


class CheckRole
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

        if($request->user()===null){
            return redirect('/login');
        }
        $action = $request->route()->getAction();
        if(isset($action['site'])){ 
            
            if($action['site']=='all')
            {
                return $next($request);   
                 
            }elseif($request->user()->validar($action['site'],$request->user()->id)){
                return $next($request);    
            }
        }
        return response('No tienes permiso para ingresar a esta área',401);
    }
}
