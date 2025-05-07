<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class AuthTest extends TestCase
{
    use RefreshDatabase;




      /**
     * A basic feature test example.
     */
    public function testRegisterUser(): void
    {
        $user = User::factory()->make();

        $password = 'password';
        $response = $this->postJson('api/register', $user->toArray() + [
            'password'  =>  $password,
            'password_confirmation' =>  $password
        ]);
        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'id'    =>  1,
            'name'  =>  $user->name,
            'email' =>  $user->email,
        ]);

        $this->assertDatabaseCount('users', 1);

        $response->assertJson(fn(AssertableJson $json)=>
            $json->where('id', 1)
                ->where('name', $user->name)
                ->where('email', $user->email)
                ->etc()
        );

        $response = $this->postJson('api/register', []);
        $response->assertStatus(422);
        $response->assertInvalid([
            'name' => 'The name field is required.',
            'email' => 'The email field is required.',
            'password'  =>  'The password field is required.'
        ]);

    }


       /**
     * A basic feature test example.
     */
    public function testLoginUser(): void
    {
        $password = uniqid();
        $user = User::factory()->create([
            'password'  =>  $password,
        ]);

        $response = $this->postJson('api/login', $user->toArray() + [
            'password'  =>  $password,
        ]);
        $response->assertStatus(200);

        $response->assertJson(fn(AssertableJson $json)=>
        $json->has('data', fn(AssertableJson $json)=>
            $json->where('id', 1)
                ->where('name', $user->name)
                ->where('email', $user->email)
                ->etc()
            )
            ->has('token')
        );


        $response = $this->postJson('api/login', []);
        $response->assertStatus(422);
        $response->assertInvalid([
            'email' => 'The email field is required.',
            'password'  =>  'The password field is required.'
        ]);
    }




       /**
     * A basic feature test example.
     */
    public function testLogoutUser(): void
    {
        $password = uniqid();
        $user = User::factory()->create([
            'password'  =>  $password,
        ]);

        Sanctum::actingAs($user);

        $response = $this->withCredentials()->postJson('api/logout');
        $response->assertStatus(200);

        // $response->assertJson(fn(AssertableJson $json)=>
        // $json->has('data', fn(AssertableJson $json)=>
        //     $json->where('id', 1)
        //         ->where('name', $user->name)
        //         ->where('email', $user->email)
        //         ->etc()
        //     )
        //     ->has('token')
        // )
        // ;
    }

}
