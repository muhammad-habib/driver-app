<?php
/**
 * Created by PhpStorm.
 * User: terminator
 * Date: 19/04/18
 * Time: 04:35 م
 */

namespace Tests\Unit\Task;


use App\Enums\Task\ATaskStatus;
use App\Models\Task;
use Tests\TestCase;

class AcknowledgeTaskArrivalTest extends TestCase
{
    /**
     * @author Muhammad Habib
     * @Test  Acknowledge Task Arrival Test which is not in intransit status
     * @since 19/04/2018
     * @version 1.0
     * @return void
     */
    public function testUnIntransitTask()
    {
        $task = factory(Task::class)->create();
        $task->task_status_id = ATaskStatus::NEW;
        $task->driver_id = 1;
        $response = $this->post('/api/v1/tasks/acknowledge-task-arrival', ['task_id' => $task->id]);
        $response->assertStatus(403);
    }

    /**
     * @author Muhammad Habib
     * @Test  Acknowledge Task Arrival Test in intransit status
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
        $response = $this->post('/api/v1/tasks/acknowledge-task-arrival', ['task_id' => $task->id]);
        $response->assertStatus(200);
    }
}