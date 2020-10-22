<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
     public function testsRegistersSuccessfully()
     {
         $faker = \Faker\Factory::create();
         $payload = [
             'name' => 'John',
             'username' => $faker->userName,
             'email' => $faker->email,
             'password' => 't3@opst1',
             'password_confirmation' => 't3@opst1',
         ];

         $this->json('post', 'api/v1/auth/register', $payload)
             ->assertStatus(200)
             ->assertJsonStructure([
               'token',
             ]);
     }

     public function testsRequiresPasswordEmailUsernameAndName()
    {
        $this->json('post', 'api/v1/auth/register')
            ->assertStatus(400)
            ->assertJson([
              'message' => 'Bad Request',
              'data' => [
                "The name field is required.",
                "The username field is required.",
                'The email field is required.',
                "The password field is required.",
              ],
            ]);
    }

    public function testsRequirePasswordConfirmation()
    {
        $payload = [
            'name' => 'John',
            'username' => 'john',
            'email' => 'john@test.com',
            'password' => 't3@opst2',
        ];

        $this->json('post', 'api/v1/auth/register', $payload)
            ->assertStatus(400)
            ->assertJson([
              'message' => 'Bad Request',
              'data' => [
                "The password confirmation does not match.",
              ],
            ]);
    }
}
