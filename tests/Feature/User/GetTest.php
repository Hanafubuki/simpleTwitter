<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
     public function testUserDoesntExist()
     {
         $faker = \Faker\Factory::create();
         $username = $faker->userName;
         $user = \App\Models\User::factory()->create(['username' => $username]);
         $token = $user->createToken('Test access')->accessToken;
         $headers = ['Authorization' => "Bearer $token"];
         $this->json('GET', 'api/v1/users/40004', [], $headers)
             ->assertStatus(404)
             ->assertJson([
                 'message' => 'Resource not found',
                 'data' => null,
             ]);
     }



     public function testGetUser()
     {
         $faker = \Faker\Factory::create();
         $username = $faker->userName;
         $user = \App\Models\User::factory()->create(['username' => $username]);
         $token = $user->createToken('Test access')->accessToken;
         $headers = ['Authorization' => "Bearer $token"];
         $this->json('GET', 'api/v1/users/1', [], $headers)
             ->assertStatus(200)
             ->assertJsonStructure([
               'data' => [
                 'id',
                 'name',
                 'email',
                 'email_verified_at',
                 'created_at',
                 'updated_at',
                 'username',
               ],
             ]);
     }
}
