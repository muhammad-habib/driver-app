<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Lib\Log\ServerError;
use App\Models\Driver;
use App\Models\DriverShift;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShiftsController extends Controller
{
    
	 /**
     * @SWG\Get(
     *     path="/start-shift",
     *     tags={"Shift"},
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
     *         description="Bad Request",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="message",
     *                      type="string",
     *                      default="Driver did not started shift yet or his shift already ended",
     *              ),
     *              @SWG\Property(
     *                      property="details",
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
    public function startShift(Request $request)
    {

    	$token = $request->header('Authorization');

    	$driver = Driver::where('token', $token)->first();

		try{
		  	
		  	$driver_shift = DriverShift::where('driver_id', $driver->id)
		  					->whereRaw('CAST(created_at AS date) = ' . "'" . Carbon::today()->toDateString() . "'")
		  					->first();

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
		  		// bad request 
				return response()->json([
				    'message' => trans('profile.shift.already_started')
				], 400);	
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
     *     path="/end-shift",
     *     tags={"Shift"},
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
     *         description="Bad Request",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="message",
     *                      type="string",
     *                      default="Driver in duty or his shift ended",
     *              ),
     *              @SWG\Property(
     *                      property="details",
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
    public function endShift(Request $request)
    {
    	
    	$token = $request->header('Authorization');

    	$driver = Driver::where('token', $token)->first();

		try{
		  	
		  	$driver_shift = DriverShift::where('driver_id', $driver->id)
		  					->whereRaw('CAST(created_at AS date) = ' . "'" . Carbon::today()->toDateString() . "'")
		  					->first();

		  	// make sure driver started shift
		  	if( $driver->in_duty == 1 && $driver_shift ){

		  		// set driver off duty
				$driver->in_duty = 0;
				$driver->save();
				
				// set shift end time
				$driver_shift->end_at = Carbon::now()->toTimeString();
				$driver_shift->save();

		  	}else{
		  		// return bad request
				return response()->json([
				    'message' => trans('profile.shift.error_not_started')
				], 400);
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
