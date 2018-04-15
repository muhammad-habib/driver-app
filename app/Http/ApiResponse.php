<?php
namespace App\Http;
/**
 * @SWG\Definition(type="object")
 */
class ApiResponse
{
    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    public $code;
    /**
     * @SWG\Property
     * @var string
     */
    public $type;
    /**
     * @SWG\Property
     * @var string
     */
    public $message;
}