<?php

namespace App\Http\Controllers\DriverApp;

use App\Http\Controllers\Controller;
use App\Lib\Log\ServerError;
use App\Lib\Log\ValidationError;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class AuthController extends Controller
{
    
    /**
    *	Driver Login
    *
    *	@param Request $request
    * 	@return Json
    */

    /**
     * @SWG\Post(
     *     path="/v1/login",
     *     summary="Driver Login",
     *     tags={"Driver Auth"},
     *     description="Driver Login with Username and Password",
     *     operationId="login",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="user_name",
     *         in="formData",
     *         description="Driver Username",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         description="Driver Password",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation returns driver token",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="message",
     *                      type="string",
     *              ),
     *              @SWG\Property(
     *                      property="data",
     *                      type="string",
     *              )
     *         )
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Validation Errors",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="message",
     *                      type="string",
     *                      default="Fields are invalid",
     *              ),
     *              @SWG\Property(
     *                      property="details",
     *                      type="string",
     *              )
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="username and password are not correct",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="message",
     *                      type="string",
     *              )
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="SERVER ERROR",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="message",
     *                      type="string",
     *                      default="Server Error",
     *              ),
     *              @SWG\Property(
     *                      property="details",
     *                      type="string",
     *              )
     *         )
     *     ),
     *     security={
     *       {"default": {}}
     *     }
     * )
     */
    public function login(Request $request)
    {

    	// check input validation
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'password' => 'required'
        ]);
        
        // return validation errors if detected
        if ($validator->fails()){
            return ValidationError::handle($validator);
        }
        
        try{

            // get driver
            $driver = Driver::where('user_name',  $request->get('user_name'))->first();

            // return failed message if driver doesn't exist
            if(!$driver){
                return response()->json([
                    'message' => trans('driver_auth.login.error.user_name')
                ], 401);
            }

            // comparing hashed password & if not equal to driver password in db return error message
            if (!Hash::check($request->get('password'), $driver->password))
            {
                return response()->json([
                    'message' => trans('driver_auth.login.error.password')
                ], 401);
            }
            
            // generate token
            $customClaims = ['sub' => $driver->id, 'app' => 'driver'];
            $payload = JWTFactory::make($customClaims);
            $token = JWTAuth::encode($payload);

            // store token
            $driver->token = $token->get();
            $driver->save();

            // return driver token
            return response()->json([
                'message' => trans('driver_auth.login.success'),
                'data' =>  $driver->token,
            ], 200);

        }catch (\Exception $e){

            return ServerError::handle($e);
        }


    }

    /**
    *   Driver logout 
    *   
    *   @param Request $request
    *   @return Json
    */

    /**
     * @SWG\Get(
     *     path="/v1/logout",
     *     summary="Driver Logout",
     *     tags={"Driver Auth"},
     *     operationId="logout",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Driver token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Driver Logged out successfully",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="message",
     *                      type="string",
     *              ),
     *         )
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="SERVER ERROR",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="message",
     *                      type="string",
     *                      default="Server Error",
     *              ),
     *              @SWG\Property(
     *                      property="details",
     *                      type="string",
     *              )
     *         )
     *     ),
     *     security={
     *       {"default": {}}
     *     }
     * )
     */
    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        
        try{
            
            Driver::where('token', $token)->update(['token' => null]);
            
            return response()->json([
                'message' => trans('driver_auth.logout_success')
            ], 200);

        }catch (\Exception $e){

            return ServerError::handle($e);
        }
        
    }

}
