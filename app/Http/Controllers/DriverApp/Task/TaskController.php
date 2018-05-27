<?php

namespace App\Http\Controllers\DriverApp\Task;

use App\Enums\Task\ATaskOperationType;
use App\Enums\Task\ATaskStatus;
use App\Events\Task\AcknowledgeTaskArrival;
use App\Events\Task\AcknowledgeTaskFailure;
use App\Events\Task\AssignTask;
use App\Events\Task\ReAssignTask;
use App\Events\Task\RefuseTask;
use App\Events\Task\DeliverTask;
use App\Events\Task\StartTask;
use App\Lib\Log\LogicalError;
use App\Lib\Log\ServerError;
use App\Lib\Log\ValidationError;
use App\Models\Driver;
use App\Models\Task;
use App\Models\TaskOperation;
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

    /**
     * @SWG\Post(
     *     path="/v1/tasks/deliver-task",
     *     summary="Driver Can Deliver Task",
     *     tags={"Task"},
     *     description="Driver Can Deliver Task",
     *     operationId="deliverTask",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="task_id",
     *         in="formData",
     *         description="Task ID to deliver",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="message",
     *                      type="string",
     *                      default="Task delivered Successfully"
     *              )
     *         )
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Failed Operation",
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
     *         )
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="SERVER ERROR",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="success",
     *                      type="boolean",
     *                      default=false
     *              ),
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
    public function deliverTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => 'required|numeric|exists:tasks,id',
        ]);

        if ($validator->fails())
            return ValidationError::handle($validator);

        try{
            // Get Task
            $task = Task::find($request->task_id);
            //Get Driver
            $driver = Driver::query()->find(1);
            //Check if Task Driver is the same Driver
            if ($task->driver_id != $driver->id)
                return LogicalError::handle('task.deliverTask.invalidTaskDriver');
            // Check Task to be in INTRANSIT Status
            if ($task->task_status_id != ATaskStatus::INTRANSIT)
                return LogicalError::handle('task.deliverTask.invalidTaskStatus');
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

            return Response()->json([
                'message' => trans('task.startTask.successfully'),
            ],200);

        }catch (\Exception $e){
            return ServerError::handle($e);
        }
    }

    /**
     * @author Mahmoud Soliman
     * @api refuse task by driver
     * @since 17/04/2018
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @internal param $Request -> task_id
     * @internal param $Request -> rejection_reason
     * @version 1.0
     */

    public function refuseTask(Request $request)
    {
        try {

            // make the needed parameters validation
            $validator = Validator::make($request->all(),[
                'task_id' => 'required|numeric|exists:tasks,id',
                'reason' => 'string'
            ]);

            // return errors if any
            if($validator->fails()){
                return ValidationError::handle($validator);
            }

            // get the task
            $task = Task::find($request->task_id);

            // change the task status to be Refused and store the reason if any
            $task->update([
                'task_status_id' => ATaskStatus::REFUSED
            ]);

            if($request->has('reason') && trim($request->reason) != ''){

                // TODO add created by driver
                TaskOperation::create([
                    'task_id' => $task->id,
                    'description' => $request->reason,
                    'operation_type_id' => ATaskOperationType::TASK_REFUSED
                ]);
            }

            // raise the refuse task event
            event(new RefuseTask($task));

            return Response()->json([
                'message' => trans('task.refuseTask.successfully'),
            ],200);

        }catch (\Exception $e){
            return ServerError::handle($e);
        }
    }

    /**
     * @author Muhammad Habib
     * @api Deliver task by driver
     * @since 18/04/2018
     * @param Request $request
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */


    /**
     * @SWG\Post(
     *     path="/v1/tasks/acknowledge-task-failure",
     *     summary="Driver Can Acknowledge Task Failure",
     *     tags={"Task"},
     *     description="Driver Can Acknowledge Task Failure",
     *     operationId="acknowledgeTaskFailure",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="task_id",
     *         in="formData",
     *         description="Task ID to acknowledge failure",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="message",
     *                      type="string",
     *                      default="Task Failure"
     *              )
     *         )
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Failed Operation",
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
     *         )
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="SERVER ERROR",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="success",
     *                      type="boolean",
     *                      default=false
     *              ),
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

    public function acknowledgeTaskFailure(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => 'required|numeric|exists:tasks,id',
        ]);

        if ($validator->fails())
            return ValidationError::handle($validator);

        try{
            // Get Task
            $task = Task::find($request->task_id);
            //Get Driver
            $driver = Driver::query()->find(1);
            //Check if Task Driver is the same Driver
            if ($task->driver_id != $driver->id)
                return LogicalError::handle('task.taskFailure.invalidTaskDriver');
            // Check Task to be in INTRANSIT Status
            if ($task->task_status_id != ATaskStatus::INTRANSIT)
                return LogicalError::handle('task.taskFailure.invalidTaskStatus');
            $task->task_status_id = ATaskStatus::FAILED;
            $task->save();
            // raise Acknowledge Task Failure event
            event(new AcknowledgeTaskFailure($task));

            return response()->json([
                'message' => trans('task.taskFailure.successfully'),
            ], 200);

        }catch (\Exception $e){
            return ServerError::handle($e);
        }
    }

    /**
     * @author Muhammad Habib
     * @api Assign task to driver
     * @since 19/04/2018
     * @param Request $request
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @SWG\Post(
     *     path="/v1/tasks/assign-task",
     *     summary="Admin Can Assign task to driver",
     *     tags={"Task"},
     *     description="Admin Can Assign task to driver",
     *     operationId="assignTask",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="task_id",
     *         in="formData",
     *         description="Task ID to be assigned",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="driver_id",
     *         in="formData",
     *         description="Driver ID to assign",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="message",
     *                      type="string",
     *                      default="Task is assigned successfully"
     *              )
     *         )
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Failed Operation",
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
     *         )
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="SERVER ERROR",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="success",
     *                      type="boolean",
     *                      default=false
     *              ),
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

    public function assignTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => 'required|numeric|exists:tasks,id',
            'driver_id' => 'required|numeric|exists:drivers,id',
        ]);

        if ($validator->fails())
            return ValidationError::handle($validator);

        try{

            // Get Task
            $task = Task::query()->find($request->task_id);

            //Get Driver
            $driver = Driver::query()->find($request->driver_id);

            //Check if Task Company is the same with Driver
            if ($task->company_id != $driver->company_id)
                return LogicalError::handle('task.assignTask.invalidTaskDriver');

            //Check if Driver is on duty
            if (!$driver->on_duty)
                return LogicalError::handle('task.assignTask.invalidTaskDriver');

            // Check Task to be in New Status
            if ($task->task_status_id != ATaskStatus::NEW)
                return LogicalError::handle('task.assignTask.invalidTaskStatus');

            $task->driver_id = $request->driver_id;
            $task->task_status_id = ATaskStatus::READY;
            $task->save();

            // raise Assign Task event
            event(new AssignTask($task));

            return response()->json([
                'message' => trans('task.assignTask.successfully'),
            ], 200);

        }catch (\Exception $e){
            return ServerError::handle($e);
        }
    }

    /**
     * @author Muhammad Habib
     * @api Reassign task to driver
     * @since 19/04/2018
     * @param Request $request
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */


    /**
     * @SWG\Post(
     *     path="/v1/tasks/reassign-task",
     *     summary="Admin Can Reassign task to driver",
     *     tags={"Task"},
     *     description="Admin Can Reassign task to driver",
     *     operationId="ReassignTask",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="task_id",
     *         in="formData",
     *         description="Task ID to be reassigned",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="driver_id",
     *         in="formData",
     *         description="Driver ID to reassign",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="message",
     *                      type="string",
     *                      default="Task is reassigned successfully"
     *              )
     *         )
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Failed Operation",
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
     *         )
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="SERVER ERROR",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="success",
     *                      type="boolean",
     *                      default=false
     *              ),
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

    public function ReassignTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => 'required|numeric|exists:tasks,id',
            'driver_id' => 'required|numeric|exists:drivers,id',
        ]);

        if ($validator->fails())
            return ValidationError::handle($validator);

        try{

            // Get Task
            $task = Task::query()->find($request->task_id);

            //Get Driver
            $driver = Driver::query()->find($request->driver_id);

            //Check if Task Company is the same with Driver
            if ($task->company_id != $driver->company_id)
                return LogicalError::handle('task.reassignTask.invalidTaskDriver');

            //Check if Driver is on duty
            if (!$driver->on_duty)
                return LogicalError::handle('task.reassignTask.invalidTaskDriver');

            // Check Task to be in Ready Status
            if ($task->task_status_id != ATaskStatus::READY)
                return LogicalError::handle('task.reassignTask.invalidTaskStatus');

            $task->driver_id = $request->driver_id;
            $task->save();

            // raise reassign Task event
            event(new ReAssignTask($task));

            return response()->json([
                'message' => trans('task.reassignTask.successfully'),
            ], 200);

        }catch (\Exception $e){
            return ServerError::handle($e);
        }
    }



    /**
     * @author Muhammad Habib
     * @api Acknowledge task arrival
     * @since 19/04/2018
     * @param Request $request
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */



    /**
     * @SWG\Post(
     *     path="/v1/tasks/acknowledge-task-arrival",
     *     summary="Driver Can Acknowledge Task Arrival",
     *     tags={"Task"},
     *     description="Driver Can Acknowledge Task Arrival",
     *     operationId="acknowledgeTaskArrival",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="task_id",
     *         in="formData",
     *         description="Task ID to acknowledge arrival",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="message",
     *                      type="string",
     *                      default="Task Arrival"
     *              )
     *         )
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Failed Operation",
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
     *         )
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="SERVER ERROR",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="success",
     *                      type="boolean",
     *                      default=false
     *              ),
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

    public function acknowledgeTaskArrival(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => 'required|numeric|exists:tasks,id',
        ]);

        if ($validator->fails())
            return ValidationError::handle($validator);

        try{
            // Get Task
            $task = Task::find($request->task_id);
            //Get Driver
            $driver = Driver::query()->find(1);
            //Check if Task Driver is the same Driver
            if ($task->driver_id != $driver->id)
                return LogicalError::handle('task.taskArrival.invalidTaskDriver');
            // Check Task to be in INTRANSIT Status
            if ($task->task_status_id != ATaskStatus::INTRANSIT)
                return LogicalError::handle('task.taskArrival.invalidTaskStatus');
            $task->task_status_id = ATaskStatus::ARRIVAL;
            $task->save();
            // raise Acknowledge Task Arrival event
            event(new AcknowledgeTaskArrival($task));

            return response()->json([
                'message' => trans('task.taskArrival.successfully'),
            ], 200);

        }catch (\Exception $e){
            return ServerError::handle($e);
        }
    }

    /**
     * @author Muhammad Habib
     * @api  Get Current Tasks
     * @since 23/04/2018
     * @param Request $request
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @SWG\Get(
     *     path="/v1/tasks/ready-tasks",
     *     summary="Driver Can see ready tasks",
     *     tags={"Task"},
     *     description="Driver Can see ready tasks",
     *     operationId="readyTasks",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="status",
     *                      type="string",
     *                      default=200
     *                  ),
     *              @SWG\Property(
     *                      property="success",
     *                      type="boolean",
     *                      default=true
     *                  ),
     *              @SWG\Property(
     *                      type="array",
     *                      property="data",
     *                      @SWG\Items(ref="#/definitions/Task")
     *                  ),
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="SERVER ERROR",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="success",
     *                      type="boolean",
     *                      default=false
     *              ),
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

    public function readyTasks(Request $request)
    {
        try {
            //Get Driver
            $driver = Driver::query()->find(1);
            return response()->json([
                'success' => true,
                'status' => 200,
                'data'=>$driver->readyTasks,
            ]);
        }catch (\Exception $e){
            return ServerError::handle($e);
        }


    }
}
