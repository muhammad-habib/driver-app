<?php
/**
 * Created by PhpStorm.
 * User: terminator
 * Date: 19/04/18
 * Time: 12:46 م
 */

namespace Tests\Unit\Task;


use App\Enums\Task\ATaskStatus;
use App\Models\Driver;
use App\Models\Task;
use Tests\TestCase;

class AssignTaskTest extends TestCase
{
    /**
     * @author Muhammad Habib
     * @Test Assign task which is not in new status
     * @since 19/04/2018
     * @version 1.0
     * @return void
     */
    public function testNotNewTask()
    {
        $task = factory(Task::class)->create();
        $task->task_status_id = ATaskStatus::READY;
        $response = $this->post('/api/v1/tasks/assign-task', ['task_id' => 1, 'driver_id' => 1]);
        $response->assertStatus(403);
    }


    /**
     * @author Muhammad Habib
     * @Test Assign task to idle driver
     * @since 19/04/2018
     * @version 1.0
     * @return void
     */
    public function testIdleDriver()
    {
        $task = factory(Task::class)->create();
        $task->task_status_id = ATaskStatus::NEW;
        $task->company_id = 1;
        $task->save();

        $driver = factory(Driver::class)->create();
        $driver->on_duty = false;
        $driver->company_id = 1;
        $driver->save();

        $response = $this->post('/api/v1/tasks/assign-task', ['task_id' => $task->id, 'driver_id' => $driver->id]);
        $response->assertStatus(403);
    }

    /**
     * @author Muhammad Habib
     * @Test Assign task which is in new status
     * @since 19/04/2018
     * @version 1.0
     * @return void
     */
    public function testNewTask()
    {
        $task = factory(Task::class)->create();
        $task->task_status_id = ATaskStatus::NEW;
        $task->company_id = 1;
        $task->save();

        $driver = factory(Driver::class)->create();
        $driver->on_duty = true;
        $driver->company_id = 1;
        $driver->save();

        $response = $this->post('/api/v1/tasks/assign-task', ['task_id' => $task->id, 'driver_id' => $driver->id]);
        $response->assertStatus(200);
    }
}