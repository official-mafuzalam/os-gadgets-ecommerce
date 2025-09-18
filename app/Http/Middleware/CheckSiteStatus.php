<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckSiteStatus
{
    public function handle(Request $request, Closure $next)
    {
        $data = ['run' => true];
        if (isset($data['run']) && $data['run'] === false) {
            abort(503, 'The site is temporarily down.');
        }

        return $next($request);
    }
}
