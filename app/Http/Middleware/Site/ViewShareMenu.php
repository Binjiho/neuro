<?php

namespace App\Http\Middleware\Site;

use Closure;
use Illuminate\Http\Request;

class ViewShareMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        view()->share([
            'menu' => config('site.menu-' . checkUrl()) ?? [],
        ]);

        return $next($request);
    }
}
