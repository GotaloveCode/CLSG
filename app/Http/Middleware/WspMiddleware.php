<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WspMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('web')->check()) {
            if (auth()->user()->hasRole('wsp')) {
                $wsp = auth()->user()->wsps()->first();
                $eoi = $wsp->eoi ?? null;
                $bcp = $wsp->bcp;
                $erp = $wsp->erp;
                view()->share('wsp', $wsp);
                view()->share('eoi', $eoi);
                view()->share('bcp', $bcp);
                view()->share('erp', $erp);
            }
        }
        return $next($request);
    }
}
