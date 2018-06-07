<?php

namespace App\Http\Middleware;

use App\Lib\Log\ServerError;
use Closure;
use App\Models\Driver;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class DriverAuth
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
        
        $token = $request->header('Authorization');

        try{

          if(!$token) {
            return Response()->json([
                'error' => 'Authentication Required'
            ],404);
          }
               
          $driver = Driver::where('token', $token)->first();

          if (!$driver){
            return response()->json([
                'message' => 'Not Authenticated',
              ], 401);
          }

        } catch (\Exception $e){

            return ServerError::handle($e);
        }

        return $next($request);
    }

}
