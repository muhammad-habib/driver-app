<?php
/**
 * Created by PhpStorm.
 * User: terminator
 * Date: 17/04/18
 * Time: 05:28 م
 */
namespace Tests\Unit\Task;


use App\Enums\Task\ATaskStatus;
use App\Models\Task;
use Tests\TestCase;

class DeliverTaskTest extends TestCase
{
    /**
     * @author Muhammad Habib
     * @api Deliver task which is not in intransit status
     * @since 17/04/2018
     * @version 1.0
     * @return void
     */
    public function testUnIntransitTask()
    {
        $response = $this->post('/api/v1/tasks/deliver-task', ['task_id' => 1]);
        $response->assertStatus(400);
    }

    /**
     * @author Muhammad Habib
     * @api Deliver task which is in intransit status
     * @since 17/04/2018
     * @version 1.0
     * @return void
     */
    public function testIntransitTask()
    {
        $task = factory(Task::class)->create();
        $task->task_status_id = ATaskStatus::INTRANSIT;
        $task->driver_id = 1;
        $task->save();
        $response = $this->post('/api/v1/tasks/deliver-task', ['task_id' => $task->id]);
        $response->assertStatus(200);
    }

}