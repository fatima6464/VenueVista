<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ShareViewData
{
    public function handle(Request $request, Closure $next): Response
    {
        View::share('user', auth()->user());
        View::share('success', session('success'));
        View::share('error', session('error'));
        View::share('currentPath', $request->path());

        return $next($request);
    }
}
