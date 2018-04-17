<?php
/**
 * Created by PhpStorm.
 * User: terminator
 * Date: 17/04/18
 * Time: 05:28 م
 */
namespace Tests\Feature;


use Tests\TestCase;

class Task extends TestCase
{
    /**
     * @author Muhammad Habib
     * @api Deliver task by driver
     * @since 17/04/2018
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */
    public function deliverTask()
    {
        $response = $this->post('/v1/tasks/deliver-task');
        $response->assertStatus(200);
    }

}