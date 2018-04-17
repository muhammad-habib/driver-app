<?php

namespace App\Http\Middleware;

use Closure;
use function MongoDB\BSON\toJSON;

class Test
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->bearerToken() == '123')
            return $next($request);
        else
            return response()->json([
                'success' => false,
                'status' => 401,
                'data'=>[],
            ]);
    }
}
