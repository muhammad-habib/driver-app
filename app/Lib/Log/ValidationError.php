<?php
/**
 * Created by PhpStorm.
 * User: anoos
 * Date: 15/04/18
 * Time: 02:16 م
 */

namespace App\Lib\Log;



class ValidationError
{
    public static function handle($validator) {

        return Response()->json([
            'message' => trans('validation.invalidFields'),
            'details' => $validator->errors()
        ], 400);

    }
}