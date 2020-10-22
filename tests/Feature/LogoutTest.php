<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use app\Models\User;

class LogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
     public function testUserIsLoggedOut()
     {
         $faker = \Faker\Factory::create();
         $username = $faker->userName;
         $user = \App\Models\User::factory()->create(['username' => $username]);
         $token = $user->createToken('Test access')->accessToken;
         $headers = ['Authorization' => "Bearer $token"];

         $this->json('get', '/api/v1/tweets', [], $headers)->assertStatus(200);
         $this->json('post', '/api/v1/auth/logout', [], $headers)
              ->assertStatus(200)
              ->assertJson([
                 'message' => 'You have been successfully logged out!',
              ]);


         $this->assertEquals(true, auth('api')->user()->token()->revoke());
     }

}
