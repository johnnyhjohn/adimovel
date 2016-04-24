<?php

namespace App\Http\Middleware;

use Closure;

class AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        
        if (!$request->user()) {
            return redirect()->guest('/admin/login');
        }
        if ($request->user()) {
            if (!$request->user()->admin) {
                return redirect()->guest('/admin');
            }else{
                return $next($request);
            }
        }
        return $next($request);
    }
}
