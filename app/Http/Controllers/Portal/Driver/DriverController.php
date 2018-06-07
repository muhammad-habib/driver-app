<?php

namespace App\Http\Controllers\Portal\Driver;

use App\Http\Controllers\Controller;
use App\Lib\Log\ServerError;
use App\Lib\Log\ValidationError;
use App\Models\Company;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    
    /**
     * List company drivers with their teams
     * @author Amr Elsayed
     * @since 6/7/2018
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @version 1.0
     */
    public function index(Request $request)
    {
    	try{

            // validation
            $validator = Validator::make($request->all(),[
                'company_id' => 'required|numeric|exists:companies,id',
            ]);

            if ($validator->fails()){
                return ValidationError::handle($validator);
            }

            $drivers = Driver::where('company_id', $request->company_id)->with('teams')->get();

            return Response()->json([
                'message' => trans('driver.confirm.retrieve'),
                'data' => $drivers
            ],200);

        }catch (\Exception $e){
            return ServerError::handle($e);
        }
    }

     /**
     * Create Driver
     * @author Amr Elsayed
     * @since 6/7/2018
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @version 1.0
     */
    public function create(Request $request)
    {
    	try{

            // validation
            $validator = Validator::make($request->all(),[
                'user_name' => 'required|string',
                'password' => 'required|string',
                'company_id' => 'required|numeric|exists:companies,id',
                'active' => 'boolean',
                'teams' => 'array|exists:teams,id',
            ]);

            if ($validator->fails()){
                return ValidationError::handle($validator);
            }

            if(!in_array('driver', $request->all())){
                $active = true;
            }else{
               $active = $request->active; 
            }

            $driver = Driver::create([
            	'name' => $request->name,
            	'user_name' => $request->user_name,
            	'password' => Hash::make($request->password),
            	'company_id' => $request->company_id,
            	'mobile' => $request->mobile,
            	'awb' => $request->awb,
            	'active' => $active,
            	'image' => $request->image,
            ]);

            // add the attached teams to driver
            if($request->has('teams') && !empty($request->teams)){
                $driver->teams()->attach($request->teams);
            }

            return Response()->json([
                'message' => trans('driver.confirm.create'),
            ],200);

        }catch (\Exception $e){
            return ServerError::handle($e);
        }
    }

    /**
     * update driver
     * @author Amr Elsayed
     * @since 6/7/2018
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @version 1.0
     */
    public function update(Request $request)
    {
        try {

            // validation
            $validator = Validator::make($request->all(), [
                'user_name' => 'required|string',
                'password' => 'required|string',
                'driver_id' => 'required|numeric',
                'company_id' => 'numeric|exists:companies,id',
                'teams' => 'array|exists:teams,id',
            ]);

            if ($validator->fails()) {
                return ValidationError::handle($validator);
            }

            // get driver
            $driver = Driver::find($request->driver_id);

            $data = $request->all();

            foreach($data as $key => $value){
                if($value == ''){
                    unset($data[$key]);
                }
            }

            $driver->update($data);

            if($request->has('teams') && !empty($request->teams)){
                $driver->teams()->sync($request->teams);
            }

            return Response()->json([
                'message' => trans('driver.confirm.update'),
            ],200);

        }catch (\Exception $e){
            return ServerError::handle($e);
        }
    }


    public function delete(Request $request)
    {
        try{

            // validation
            $validator = Validator::make($request->all(), [
                'driver_id' => 'required|numeric|exists:drivers,id',
            ]);

            if ($validator->fails()) {
                return ValidationError::handle($validator);
            }

            // get driver
            $driver = Driver::find($request->driver_id);

            // remove all related teams from the pivot
            $driver->drivers()->detach();

            // remove the driver itself
            $driver->delete();

            return Response()->json([
                'message' => trans('driver.confirm.delete'),
            ],200);


        }catch (\Exception $e){
            return ServerError::handle($e);
        }
    }
}
