<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Todo;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testGetTodos(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);;

        $count = mt_rand(30, 120);

        Todo::factory()->count($count)->create([
            'user_id'   =>  $user->id,
        ]);

        $response = $this->getJson('api/todos');

        $response->assertJsonCount($count, 'data');

        $response->assertStatus(200);
    }


    /**
     * A basic feature test example.
     */
    public function testGetTodo(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);;

        $todo = Todo::factory()->create([
            'user_id'   =>  $user->id,
        ]);

        $response = $this->getJson('api/todos/'.$todo->id);
        $response->assertStatus(200);

        $this->assertDatabaseHas('todos', [
            'title' => $todo->title,
            'body' => $todo->body,
        ]);

        $response->assertJson(fn(AssertableJson $json)=>
            $json->has('data', fn(AssertableJson $json)=>
                $json->where('id', 1)
                    ->where('title', $todo->title)
                    ->where('body', $todo->body)
                    ->etc()
            )
        );

        $response = $this->getJson('api/todos/'.mt_rand(2, 100));
        $response->assertNotFound();
    }


      /**
     * A basic feature test example.
     */
    public function testCreateTodo(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);;

        $todo = Todo::factory()->make([
            'user_id'   =>  $user->id,
        ]);

        $response = $this->postJson('api/todos', $todo->toArray());
        $response->assertStatus(201);

        $this->assertDatabaseHas('todos', [
            'title' => $todo->title,
            'body' => $todo->body,
            'user_id'   =>  $user->id,
        ]);

        $this->assertDatabaseCount('todos', 1);

        $response->assertJson(fn(AssertableJson $json)=>
            $json->has('data', fn(AssertableJson $json)=>
                $json->where('id', 1)
                    ->where('title', $todo->title)
                    ->where('body', $todo->body)
                    ->where('user_id', $todo->user_id)
                    ->etc()
            )
        );

        $response = $this->postJson('api/todos', []);
        $response->assertStatus(422);
        $response->assertInvalid([
            'title' => 'The title field is required.',
            'body'  =>  'The body field is required.'
        ]);
    }


     /**
     * A basic feature test example.
     */
    public function testUpdateTodo(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);;

        $todo = Todo::factory()->create([
            'user_id'   =>  $user->id,
        ]);

        $new_title = $todo->title.' '.'updated';
        $new_body = $todo->body.' '.'updated';
        $response = $this->putJson('api/todos/'.$todo->id,  [
            'title' =>  $new_title,
            'body' =>  $new_body,
        ]);

        $response->assertStatus(202);

        $this->assertDatabaseHas('todos', [
            'title' => $new_title,
            'body' => $new_body,
            'user_id'   =>  $user->id,
        ]);

        $this->assertDatabaseCount('todos', 1);

        $response->assertJson(fn(AssertableJson $json)=>
            $json->has('data', fn(AssertableJson $json)=>
                $json->where('id', 1)
                    ->where('title', $new_title)
                    ->where('body', $new_body)
                    ->where('user_id', $todo->user_id)
                    ->etc()
            )
        );

        $user = User::factory()->create();
        Sanctum::actingAs($user);;

        $response = $this->putJson('api/todos/'.$todo->id,  [
            'title' =>  $new_title,
            'body' =>  $new_body,
        ]);

        $response->assertStatus(403);


        $response = $this->putJson('api/todos/'.$todo->id, []);
        $response->assertStatus(422);
        $response->assertInvalid([
            'title' => 'The title field is required.',
            'body'  =>  'The body field is required.'
        ]);
    }



     /**
     * A basic feature test example.
     */
    public function testDeleteTodo(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);;

        $todo = Todo::factory()->create([
            'user_id'   =>  $user->id,
        ]);

        $response = $this->deleteJson('api/todos/'.$todo->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('todos', [
            'title' => $todo,
            'body' => $todo,
            'user_id'   =>  $user->id,
        ]);

        $this->assertDatabaseCount('todos', 0);

        $todo = Todo::factory()->create([
            'user_id'   =>  $user->id,
        ]);

        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->deleteJson('api/todos/'.$todo->id);

        $response->assertStatus(403);
    }
}
