<?php
/**
 * Created by PhpStorm.
 * User: terminator
 * Date: 23/04/18
 * Time: 01:02 م
 */

namespace Tests\Unit\Task;


use Tests\TestCase;

class ReadyTasksTest extends TestCase
{
    /**
     * @author Muhammad Habib
     * @api Driver can see his ready tasks
     * @since 23/04/2018
     * @version 1.0
     * @return void
     */
    public function testReadyTasks()
    {
        $response = $this->get('/api/v1/tasks/ready-tasks');
        $response->assertStatus(200);
    }
}