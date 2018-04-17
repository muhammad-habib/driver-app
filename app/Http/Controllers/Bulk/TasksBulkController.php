<?php

namespace App\Http\Controllers\Bulk;

use App\Events\Bulk\CreatedUnAssignedBulk;
use App\Lib\Log\ServerError;
use App\Lib\Log\ValidationError;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bulk;
use Illuminate\Support\Facades\Validator;

class TasksBulkController extends Controller
{

    /**
     * @SWG\Post(
     *     path="/tasks-bulk/createUnAssignedBulkOfTasks",
     *     summary="create un assigned bulk of tasks",
     *     description="Multiple status values can be provided with comma separated strings",
     *     operationId="createUnAssignedBulkOfTasks",
     *     produces={ "application/json"},
     *     tags={bulk},
     *     @SWG\Parameter(  
     *         name="tasks",
     *         in="query",
     *         description="",
     *         required=true,
     *         type="array",
     *         @SWG\Items(
     *             type="string",
     *             enum={"available", "pending", "sold"},
     *             default="available"
     *         ),
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Pet")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid status value",
     *     ),
     *     security={
     *       {"petstore_auth": {"write:pets", "read:pets"}}
     *     }
     * )
     */
    
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
                'tasks.*.total_price' => 'required|numeric',
                'tasks.*.payment_type_id' => 'required|numeric',
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

            return response()->json([
                'message' => trans('bulk.createAssignedBulk.successfully'),
            ], 200);

        } catch (\Exception $e) {
            return ServerError::handle($e);
        }
    }


    //
}
