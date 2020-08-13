<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        if (!authAdmin()->status) {
            session()->flash('error', 'حسابك معطّل حالياً');
            auth()->guard('admin')->logout();
            return back();
        }
        return $next($request);
    }
}
