<?php

namespace App\Http\Controllers\Task;

use App\Lib\Log\ValidationError;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function deliverTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task-id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return ValidationError::handle($validator);
        }

        dd($request->all());
    }
}
