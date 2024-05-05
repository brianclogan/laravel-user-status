<?php

namespace BrianLogan\LaravelUserStatus\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (auth()->check()) {
            if (auth()->user()->using_statuses ?? false) {
                /** @phpstan-ignore-next-line */
                auth()->user()->setStatus(config('user-status.middleware.status'), config('user-status.middleware.reason'), config('user-status.middleware.meta'));
            }
        }

        return $response;
    }
}
