<?php
/**
 * Created by PhpStorm.
 * User: terminator
 * Date: 19/04/18
 * Time: 03:07 م
 */

namespace Tests\Unit\Task;


use App\Enums\Task\ATaskStatus;
use App\Models\Driver;
use App\Models\Task;
use Tests\TestCase;

class ReAssignTaskTest extends TestCase
{
    /**
     * @author Muhammad Habib
     * @Test Reassign task which is not in ready status
     * @since 19/04/2018
     * @version 1.0
     * @return void
     */
    public function testNotReadyTask()
    {
        $task = factory(Task::class)->create();
        $task->task_status_id = ATaskStatus::NEW;
        $task->company_id = 1;
        $response = $this->post('/api/v1/tasks/reassign-task', ['task_id' => $task->id, 'driver_id' => 1]);
        $response->assertStatus(403);
    }


    /**
     * @author Muhammad Habib
     * @Test Reassign task to idle driver
     * @since 19/04/2018
     * @version 1.0
     * @return void
     */
    public function testIdleDriver()
    {
        $task = factory(Task::class)->create();
        $task->task_status_id = ATaskStatus::READY;
        $task->company_id = 1;
        $task->driver_id = 1;
        $task->save();

        $driver = factory(Driver::class)->create();
        $driver->on_duty = false;
        $driver->company_id = 1;
        $driver->save();

        $response = $this->post('/api/v1/tasks/reassign-task', ['task_id' => $task->id, 'driver_id' => $driver->id]);
        $response->assertStatus(403);
    }

    /**
     * @author Muhammad Habib
     * @Test Reassign task which is in Ready status
     * @since 19/04/2018
     * @version 1.0
     * @return void
     */
    public function testReadyTask()
    {
        $task = factory(Task::class)->create();
        $task->task_status_id = ATaskStatus::READY;
        $task->company_id = 1;
        $task->driver_id = 1;
        $task->save();

        $driver = factory(Driver::class)->create();
        $driver->on_duty = true;
        $driver->company_id = 1;
        $driver->save();

        $response = $this->post('/api/v1/tasks/reassign-task', ['task_id' => $task->id, 'driver_id' => $driver->id]);
        $response->assertStatus(200);
    }

}