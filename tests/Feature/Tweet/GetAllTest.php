<?php

namespace Tests\Feature\Tweet;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetAllTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
     public function testGetTweetsUserNotAuthenticated()
     {
         $headers = ['Authorization' => "Bearer null"];
         $this->json('GET', 'api/v1/tweets', [], $headers)
             ->assertStatus(401)
             ->assertJson([
                 'message' => 'Unauthenticated.',
             ]);
     }



     public function testGetTweets()
     {
         $faker = \Faker\Factory::create();
         $username = $faker->userName;
         $user = \App\Models\User::factory()->create(['username' => $username]);
         $token = $user->createToken('Test access')->accessToken;
         $headers = ['Authorization' => "Bearer $token"];
         $this->json('GET', 'api/v1/tweets', [], $headers)
             ->assertStatus(200);
     }
}
