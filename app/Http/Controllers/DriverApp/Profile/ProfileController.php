<?php

namespace App\Http\Controllers\DriverApp\Profile;

use App\Http\Controllers\Controller;
use App\Lib\Log\ServerError;
use App\Lib\Log\ValidationError;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    
    
    
    /**
    *	Get Driver Profile Information
    *
    *	@param Request $request
    * 	@return Json
    */

    /**
     * @SWG\Get(
     *     path="/v1/profile",
     *     summary="Driver Profile",
     *     tags={"Profile"},
     *     description="Get driver profile information",
     *     operationId="edit",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="driver_id",
     *         in="query",
     *         description="Driver ID",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation returns success message",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="message",
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
     *         description="Driver not found",
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
    public function index(Request $request)
    {
    	$validator = Validator::make($request->all(), [
			'driver_id' => 'required|numeric',
      	]);

		if ($validator->fails()){
			return ValidationError::handle($validator);
		}

		try{
		  
			// get driver profile info
			$driverProfile = Driver::select('name', 'mobile', 'image', 'company_id')
								->where('id',$request->driver_id)
								->with('company')
								->first();

			// check if driver profile didn't found
			if(!$driverProfile){
			  return response()->json([
			      'message'=>trans('profile.info.error')
			  ], 401);

			}

			// return driver profile
			return response()->json([
			    'message' => trans('profile.info.success'),
			    'data' =>  $driverProfile
			], 200);

		}catch (\Exception $e){
			return ServerError::handle($e);
		}

    }

    
    /**
    *	Update Driver Information
    *
    *	@param Request $request
    * 	@return Json
    */

    /**
     * @SWG\Post(
     *     path="/v1/profile/edit",
     *     summary="Update Driver Profile",
     *     tags={"Profile"},
     *     description="Update Driver Profile Info",
     *     operationId="edit",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="driver_id",
     *         in="formData",
     *         description="Driver ID",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="name",
     *         in="formData",
     *         description="Driver Name",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="username",
     *         in="formData",
     *         description="Driver Username",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="image",
     *         in="formData",
     *         description="Driver Image",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="mobile",
     *         in="formData",
     *         description="Driver Mobile",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation returns success message",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="message",
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
     *         description="Driver not found",
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
    public function edit(Request $request)
    {
    	$validator = Validator::make($request->all(), [
			'driver_id' => 'required|numeric',
      	]);

		if ($validator->fails()){
			return ValidationError::handle($validator);
		}

		try{
		  
			// get driver profile info
			$driver = Driver::find($request->driver_id);

			// check if driver not found
			if(!$driver){
			  return response()->json([
			      'message'=>trans('profile.info.error')
			  ], 401);

			}

			//update driver info
			$driver->update($request->all());

			// return success
			return response()->json([
			    'message' => trans('profile.info.updated'),
			], 200);

		}catch (\Exception $e){
			return ServerError::handle($e);
		}
    }

}
