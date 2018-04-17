<?php
/**
 * Created by PhpStorm.
 * User: terminator
 * Date: 17/04/18
 * Time: 02:31 م
 */
namespace App\Lib\Log\Task;

use App\Lib\Log\ErrorHandler;


class TaskError implements ErrorHandler
{
    public static function handle($messge) {
        return response()->json(array('success' => false,
            'status_code' => 400,
            'message' => $messge
        ), 400);
    }
}