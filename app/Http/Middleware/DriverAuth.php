<?php

namespace App\Http\Middleware;

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
            return Response()->json(['error' => 'Authentication Required'], 404);
          }
               
          $driver = Driver::where('token', $token)->first();

          if (!$driver){
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => 'Not Authenticated',
              ]);
          }

        } catch (TokenExpiredException $e) {

          return response()->json([
            'success' => false,
            'status' => $e->getStatusCode(),
            'message' => 'token_expired',
          ]);

        } catch (TokenInvalidException $e) {

           return response()->json([
             'success' => false,
             'status' => $e->getStatusCode(),
             'message' => 'token_invalid',
           ]);

       } catch (JWTException $e) {

         return response()->json([
           'success' => false,
           'status' => $e->getStatusCode(),
           'message' => 'token_absent',
         ]);
         
       }

        return $next($request);
    }

}
