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
        Event::dispatch('simplecms.plugin.company.company_request', [$request, true]);
        return $next($request);
    }
}