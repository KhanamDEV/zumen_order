<?php

namespace Modules\Worker\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WorkerAuthenticate
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
        if (auth('workers')->check()){
            return $next($request);
        }
        return redirect()->route('worker.login');
    }
}
