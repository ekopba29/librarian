<?php

namespace App\Http\Middleware;

use App\Http\MyService\ResponseService;
use Closure;
use Illuminate\Http\Request;

class BorrowerMiddleware
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
        if(auth()->user()->role != "user") {
            ResponseService::unauthorizedStatus();
        }
        return $next($request);
    }
}
