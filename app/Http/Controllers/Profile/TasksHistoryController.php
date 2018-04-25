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
                  'status'=> 400,
                  'message'=>trans('profile.tasksHistory.error')

              ]);

          }
          return response()->json([
              'success'=> true,
              'status'=> 200,
              'tasks_history'=>$tasksHistory

          ]);

      }catch (\Exception $e){
          return ServerError::handle($e);
      }
  }

}