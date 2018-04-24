<?php

namespace App\Http\Controllers\Driver;

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
	* Uncomplete Register Function made for just testing login
	*
	*
	*/
    public function register(Request $request)
    {
    	$driver = Driver::create([
    		'name' => $request->get('name'),
    		'awb' => $request->get('awb'),
    		'company_id' => $request->get('company_id'),
           	'username' => $request->get('username'),
           	'password' => Hash::make($request->get('password')),
        ]);
        
        if($driver){
        	return 'success';
        }else{
        	return 'failed';
        }
    }

    /**
    *	Driver Login
    *
    *	@param Request $request
    * 	@return Json
    */
    public function login(Request $request)
    {

    	// check input validation
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);
        
        // return validation errors if detected
        if ($validator->fails()){
            return ValidationError::handle($validator);
        }

        // get driver from database from it's username
    	$driver = Driver::where('username',  $request->get('username'))->first();

    	// return failed message if driver doesn't exist
        if(!$driver){
        	return response()->json([
            	'success' => false,
                'status_code' => 400,
                'message' => trans('driver.login.error.username')
            ]);
        }

        // comparing hashed password & if not equal to driver password in db return error message
		if (!Hash::check($request->get('password'), $driver->password))
		{
		    return response()->json([
            	'success' => false,
                'status_code' => 400,
                'message' => trans('driver.login.error.password')
            ]);
		}
        
        // generate token
        $customClaims = ['sub' => $driver->id, 'app' => 'driver'];
        $payload = JWTFactory::make($customClaims);
        $token = JWTAuth::encode($payload);

        // store token in db
        $driver->token = $token->get();
        $driver->save();

        // return success and driver token
        return response()->json([
            'success' => true,
            'status' => 200,
            'token' =>  $driver->token,
            'data' => $driver
        ]);

    }

    /**
    *   Driver logout 
    *   
    *   @param Request $request
    *   @return Json
    */
    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        
        try{
            
            Driver::where('token', $token)->update(['token' => null]);
            
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => trans('driver.logout_success')
            ]);

        }catch (\Exception $e){

            return ServerError::handle($e);
        }
        

        
    }

}
