<?php

namespace App\Http\Middleware;

use Closure;

class EnabledTokens
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $enabledTokens = collect(config('auth.enableTokens'));
        $host = $request->getHost();

        if (!$enabledTokens->has($host) || !$enabledTokens->get($host)) {
            return response([
                'message' => 'unauthenticated'
            ], 401);
        }

        return $next($request);
    }
}
