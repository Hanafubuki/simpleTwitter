<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
     public function testGetCommentsUserNotAuthenticated()
     {
         $headers = ['Authorization' => "Bearer null"];
         $this->json('GET', 'api/v1/comments', [], $headers)
             ->assertStatus(401)
             ->assertJson([
                 'message' => 'Unauthenticated.',
             ]);
     }



     public function testGetComments()
     {
         $faker = \Faker\Factory::create();
         $username = $faker->userName;
         $user = \App\Models\User::factory()->create(['username' => $username]);
         $token = $user->createToken('Test access')->accessToken;
         $headers = ['Authorization' => "Bearer $token"];
         $this->json('GET', 'api/v1/comments', [], $headers)
             ->assertStatus(200);
     }
}
