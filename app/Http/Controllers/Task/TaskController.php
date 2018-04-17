<?php

namespace App\Http\Controllers\Task;

use App\Enums\Task\ATaskStatus;
use App\Lib\Log\ServerError;
use App\Lib\Log\Task\TaskError;
use App\Lib\Log\ValidationError;
use App\Models\Driver;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function deliverTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => 'required|integer|exists:tasks,id',
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
                return TaskError::handle(trans('task.deliverTask.invalidTaskDriver'));
            // Check Task to be in INTRANSIT Status
            if ($task->task_status_id != ATaskStatus::INTRANSIT)
                return TaskError::handle(trans('task.deliverTask.invalidTaskStatus'));
            $task->task_status_id = ATaskStatus::SUCCESSFUL;
            $task->save();
            return response()->json([
                'message' => trans('task.deliverTask.successfully'),
            ], 200);


        }catch (\Exception $e){
            return ServerError::handle($e);
        }
    }
}
