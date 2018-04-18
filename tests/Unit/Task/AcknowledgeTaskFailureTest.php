<?php
/**
 * Created by PhpStorm.
 * User: terminator
 * Date: 18/04/18
 * Time: 05:22 م
 */

namespace Tests\Unit\Task;


use App\Enums\Task\ATaskStatus;
use App\Models\Task;
use Tests\TestCase;

class AcknowledgeTaskFailureTest extends TestCase
{
    /**
     * @author Muhammad Habib
     * @Test  Acknowledge Task Failure Test which is not in intransit status
     * @since 17/04/2018
     * @version 1.0
     * @return void
     */
    public function testUnIntransitTask()
    {
        $response = $this->post('/api/v1/tasks/acknowledge-task-failure', ['task_id' => 1]);
        $response->assertStatus(403);
    }

    /**
     * @author Muhammad Habib
     * @Test  Acknowledge Task Failure Test in intransit status
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
        $response = $this->post('/api/v1/tasks/acknowledge-task-failure', ['task_id' => $task->id]);
        $response->assertStatus(200);
    }

}