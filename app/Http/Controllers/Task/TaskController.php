<?php

namespace App\Http\Controllers\Task;

use App\Enums\Task\ATaskStatus;
use App\Events\Task\DeliverTask;
use App\Events\Task\StartTask;
use App\Lib\Log\LogicalError;
use App\Lib\Log\ServerError;
use App\Lib\Log\ValidationError;
use App\Models\Driver;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * @author Muhammad Habib
     * @api Deliver task by driver
     * @since 17/04/2018
     * @param Request $request
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */
    public function deliverTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => 'required|numeric|exists:tasks,id',
        ]);

        if ($validator->fails())
            return ValidationError::handle($validator);

        try{

            // Get Task
            $task = Task::query()->find($request->task_id);
            //Get Driver
            $driver = Driver::query()->find(1);
            //Check if Task Driver is the same Driver
            if ($task->driver_id != $driver->id)
                return LogicalError::handle(trans('task.deliverTask.invalidTaskDriver'));
            // Check Task to be in INTRANSIT Status
            if ($task->task_status_id != ATaskStatus::INTRANSIT)
                return LogicalError::handle(trans('task.deliverTask.invalidTaskStatus'));
            $task->task_status_id = ATaskStatus::SUCCESSFUL;
            $task->save();
            // raise deliver task event
            event(new DeliverTask($task));
            return response()->json([
                'message' => trans('task.deliverTask.successfully'),
            ], 200);
        }catch (\Exception $e){
            return ServerError::handle($e);
        }
    }

    /**
     * @author Mahmoud Soliman
     * @api start task by driver
     * @since 17/04/2018
     * @param Request -> task_id
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */

    public function startTask(Request $request)
    {
        try {

            // make the needed parameters validation
            $validator = Validator::make($request->all(),[
                'task_id' => 'required|numeric|exists:tasks,id'
            ]);

            // return errors if any
            if($validator->fails()){
                return ValidationError::handle($validator);
            }

            // get the task
            $task = Task::find($request->task_id);

            // change the task status to be INTRANSIT
            $task->update([
                'task_status_id' => ATaskStatus::INTRANSIT
            ]);


            // raise the start task event
            event(new StartTask($task));

        }catch (\Exception $e){
            return ServerError::handle($e);
        }
    }
}
