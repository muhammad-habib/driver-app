<?php
/**
 * Created by PhpStorm.
 * User: Rasha Amer
 * Date: 4/25/2018
 * Time: 2:37 PM
 */



namespace App\Http\Controllers\Profile;

use App\Lib\Log\ServerError;
use App\Lib\Log\ValidationError;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Enums\Task\ATaskStatus;

class TasksHistoryController extends Controller
{
    /**
     * @author Rasha Amer
     * @api task's history
     * @since 25/04/2018
     * @param Request -> driver_id
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @SWG\Get(
     *     path="/profile/tasks-history",
     *     summary="Driver Tasks' History",
     *     tags={"Driver"},
     *     description="get all tasks' history for each driver",
     *     operationId="tasks' history",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="driver_id",
     *         in="formData",
     *         description="Driver ID",
     *         required=true,
     *         type="integer",
     *     )
     *     @SWG\Response(
     *         response=200,
     *         description="tasks history",
     *         @SWG\Schema(
     *              @SWG\Property(
     *                      property="data",
     *                      type="array",
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
     *         description="driver hasn't tasks' history",
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

  public function getTasksHistory(Request $request)
  {
      $validator = Validator::make($request->all(), [
          'driver_id' => 'required|numeric|exists:drivers,id',
      ]);

      if ($validator->fails())
          return ValidationError::handle($validator);

      try{
          //Get all tasks' history for specific driver
          $tasksHistory=Task::query()->where('driver_id',$request->driver_id)
                              ->whereIn('task_status_id', [ATaskStatus::SUCCESSFUL,ATaskStatus::FAILED] )
                              ->get();

          if(!$tasksHistory){
              return response()->json([
                  'success'=> false,
                  'status'=> 401,
                  'message'=>trans('profile.tasksHistory.error')

              ]);

          }
          return response()->json([
              'success'=> true,
              'status'=> 200,
              'data'=>$tasksHistory

          ]);

      }catch (\Exception $e){
          return ServerError::handle($e);
      }
  }

}