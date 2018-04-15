<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bulk;
use App\Models\Task;

class TasksBulkController extends Controller
{

    public function store(Request $request)
    {

        try{

            $validator = Validator::make($request->all(), [
                'tasks'=>'required|array',
                'bulk_id' => 'required|string',
                'tasks.*.complete_after' => 'required|date',
                'tasks.*.complete_before' => 'required|date',
                'tasks.*.address' => 'required|string',
                'tasks.*.lat' => 'required|string',
                'tasks.*.long' => 'required|string',
                'tasks.*.bulk_id' => 'numeric',
                'tasks.*.customer_name' => 'required|string',
                'tasks.*.customer_phone' => 'required|string',
                'tasks.*.city' => 'string',
                'tasks.*.area' => 'string',
                'tasks.*.country' => 'string',
                'tasks.*.street_number' => 'string',
                'tasks.*.street_name' => 'string',
            ]);
   
            if($validator->fails()){
                
                return response()->json(array('success' => false,
                    'status_code' => 400,
                    'message' => $validator->errors()
                ),400);
            }
            //create bulk 
            $bulk = new Bulk();
            $bulk->save(); 
            //add tasks to bulk
            $bulk->addTasks($request->tasks);
            //fire createdTask event
            event(new CreatedUnAssignedBulk());

        
    }catch (\Exception $e){

        return response()->json(array('success' => false,
            'message' => trans('validation.500'),
            'details' =>[
                'file'=>$e->getFile(),
                'line'=>$e->getLine(),
                'error'=>$e->getMessage(),
            ]
        ),500);

    }


}


    //
}
