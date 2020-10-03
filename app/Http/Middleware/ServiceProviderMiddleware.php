<?php

namespace App\Http\Middleware;

use Closure;

class ServiceProviderMiddleware
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
        if (auth()->user()->type != 'service_provider') {
            return response_api(false, 422, 'لا يوجد لديك صلاحية مزود خدمة', empObj());
        }

        if (!auth()->user()->is_active) {
            return response_api(false, 407, 'تم ايقاف حسابك', empObj());
        }
        if (!auth()->user()->is_verify) {
            return response_api(false, 405, 'تحقق من كود التحقق', ['token' => empObj(), 'user' => auth()->user()]);
        }
        return $next($request);
    }
}
