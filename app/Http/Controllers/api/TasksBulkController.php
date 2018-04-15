<?php

namespace App\Http\Controllers\api;

use App\Events\Bulk\CreatedUnAssignedBulk;
use App\Lib\Log\ServerError;
use App\Lib\Log\ValidationError;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bulk;
use Illuminate\Support\Facades\Validator;

class TasksBulkController extends Controller
{

    public function createUnAssignedBulkOfTasks(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'tasks' => 'required|array',
                'awb' => 'required|string',
                'tasks.*.complete_after' => 'required|date',
                'tasks.*.complete_before' => 'required|date',
                'tasks.*.address' => 'required|string',
                'tasks.*.lat' => 'required|string',
                'tasks.*.long' => 'required|string',
                'tasks.*.awb' => 'string',
                'tasks.*.customer_name' => 'required|string',
                'tasks.*.customer_phone' => 'required|string',
                'tasks.*.city' => 'string',
                'tasks.*.area' => 'string',
                'tasks.*.country' => 'string',
                'tasks.*.street_number' => 'string',
                'tasks.*.street_name' => 'string',
            ]);

            if ($validator->fails()) {
                return ValidationError::handle($validator);
            }
            //create bulk 
            $bulk = new Bulk();
            $bulk->awb = $request->awb;
            $bulk->company_id = $request->company_id;
            $bulk->save();
            //add tasks to bulk
            $bulk->addTasks($request->tasks);
            //fire createdTask event
            event(new CreatedUnAssignedBulk($bulk));
            return response();

        } catch (\Exception $e) {
            return ServerError::handle($e);
        }
    }


    //
}
