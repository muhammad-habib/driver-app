<?php
/**
 * Created by PhpStorm.
 * User: anoos
 * Date: 15/04/18
 * Time: 02:16 م
 */

namespace App\Lib\Log;



class   ValidationError
{
    public static function handle($validator) {
        return response()->json(array('success' => false,
            'status_code' => 400,
            'message' => $validator->errors()
        ), 400);
    }
}