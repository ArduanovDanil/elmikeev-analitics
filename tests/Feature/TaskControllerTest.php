<?php

namespace Tests\Feature;

use App\Http\Resources\TaskResource;
use Database\Factories\TaskFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Task;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    const API_PATH = '/api/v1/tasks';

    public function test_store()
    {
        $task = Task::factory()->raw();

        $response = $this->postJson(self::API_PATH, $task);

        $response->assertStatus(201);

    }

    public function test_index()
    {
        $response = $this->getJson(self::API_PATH);

        $response->assertStatus(200);
    }

    public function test_show()
    {
        $task = Task::factory()->create();
        $response = $this->getJson(self::API_PATH . "/{$task->id}");

        $response->assertStatus(200);
    }

    public function test_update()
    {
        $task = Task::factory()->create();
        $task->title = $this->faker()->sentence();
        $response = $this->putJson(self::API_PATH . "/{$task->id}", $task->toArray());

        $response->assertStatus(200)->assertJsonPath('data.title', $task->title);
    }

    public function test_destroy()
    {
        $task = Task::factory()->create();
        $response = $this->deleteJson(self::API_PATH . "/{$task->id}");

        $response->assertStatus(204);
    }

}
