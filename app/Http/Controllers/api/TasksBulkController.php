<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TasksBulkController extends Controller
{

    public function store(Request $request)
    {

        try{

            $validator = Validator::make($request->all(), [
                'tasks'=>'required|array',
                'batch_id' => 'required|string',
                'tasks.*.completeAfter' => 'required|date',
                'tasks.*.completeBefore' => 'required|date',
                'tasks.*.address' => 'required|string',
                'tasks.*.lat' => 'required|string',
                'tasks.*.long' => 'required|string',
                'tasks.*.batch_id' => 'numeric',
                'tasks.*.customer_name' => 'string',
                'tasks.*.customer_phone' => 'string',
                'tasks.*.city' => 'string',
                'tasks.*.area' => 'string',
                'tasks.*.country' => 'string',
                'tasks.*.streetNumber' => 'string',
                'tasks.*.streetName' => 'string',
            ]);

            $batch = new Batch();

            if($validator->fails()){
                
                return response()->json(array('success' => false,
                    'status_code' => 400,
                    'message' => $validator->errors()
                ),400);
            }



        
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
