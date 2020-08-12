<?php

namespace App\Http\Middleware;

use Closure;

class ClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->type != 'user') {
            return response_api(false, 422, 'لا يوجد لديك صلاحية مستخدم', empObj());
        }
        return $next($request);
    }
}
