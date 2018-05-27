<?php

namespace App\Http\Controllers\DriverApp\Profile;

use App\Http\Controllers\Controller;
use App\Lib\Log\ServerError;
use App\Lib\Log\ValidationError;
use App\Models\Driver;
use App\Models\DriverShift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShiftsController extends Controller
{
    
	 /**
     * @SWG\Get(
     *     path="/v1/start-shift",
     *     tags={"Shifts"},
     *     description="Start driver shift: make him in duty and capture start date",
     *     operationId="startShift",
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
     *         description="Token",
     *         required=true,
     *         type="string",
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
    public function startShift(Request $request)
    {

    	$validator = Validator::make($request->all(), [
            'driver_id' => 'required|numeric',
        ]);

        if ($validator->fails()){
            return ValidationError::handle($validator);
        }

		try{
		  	
		  	$driver_shift = DriverShift::where('driver_id', $request->driver_id)
		  					->whereDate('created_at', '=', Carbon::today()->toDateString())
		  					->first();

		  	$driver = Driver::find($request->driver_id)->first();

            // make sure driver not started shift yet
		  	if( $driver->in_duty == 0 && !$driver_shift ){

		  		// set driver in duty
				$driver->in_duty = 1;
				$driver->save();
				
				// set shift start time
				DriverShift::Create([
					'driver_id' => $driver->id,
					'start_at' => Carbon::now()->toTimeString()
				]);

		  	}else{
		  		// aleardy started
				return response()->json([
				    'message' => trans('profile.shift.already_started')
				], 200);	
		  	}
			
			// return success
			return response()->json([
			    'message' => trans('profile.shift.start')
			], 200);

		}catch (\Exception $e){
			return ServerError::handle($e);
		}
    }

	/**
     * @SWG\Get(
     *     path="/v1/end-shift",
     *     tags={"Shifts"},
     *     description="End driver shift: make him off duty and capture end date",
     *     operationId="endShift",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Token",
     *         required=true,
     *         type="string",
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
    public function endShift(Request $request)
    {
    	
        $validator = Validator::make($request->all(), [
            'driver_id' => 'required|numeric',
        ]);

        if ($validator->fails()){
            return ValidationError::handle($validator);
        }

		try{
		  	
		  	$driver_shift = DriverShift::where('driver_id', $request->driver_id)
		  					->whereDate('created_at', '=', Carbon::today()->toDateString())
		  					->first();

            $driver = Driver::find($request->driver_id)->first();
            
		  	// make sure driver started shift
		  	if( $driver->in_duty == 1 && $driver_shift ){

		  		// set driver off duty
				$driver->in_duty = 0;
				$driver->save();
				
				// set shift end time
				$driver_shift->end_at = Carbon::now()->toTimeString();
				$driver_shift->save();

		  	}else{
		  		// return shift not started
				return response()->json([
				    'message' => trans('profile.shift.not_started')
				], 200);
		  	}
			
			// return success
			return response()->json([
			    'message' => trans('profile.shift.end')
			], 200);

		}catch (\Exception $e){
			return ServerError::handle($e);
		}
    }


}
