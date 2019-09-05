<?php

namespace App\Http\Middleware;

use Closure;

class HasApiKey
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
        if($request->key == "W7W6Mkbb")
        {
            return $next($request);
        }
        
        return redirect('/home');
    }
}
