<?php

namespace SimpleCMS\Company\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Event;
use Illuminate\Http\Request;

class CompanyLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     *
     */
    public function handle(Request $request, Closure $next)
    {
        Event::dispatch(new \SimpleCMS\Company\Events\CompanyRequest($request, true));
        return $next($request);
    }
}