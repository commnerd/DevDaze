<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use App\Services\Router;
use App\Model\Group;
use Closure;

class ProxiedPath
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Router::routed($request->url())) {
            return $next($request);
        }
        return false;
    }
}
