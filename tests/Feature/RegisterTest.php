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
     public function testRegistersSuccessfully()
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

     public function testRequiresPasswordEmailUsernameAndName()
    {
        $this->json('post', 'api/v1/auth/register')
            ->assertStatus(422);
    }

    public function testRequirePasswordConfirmation()
    {
        $payload = [
            'name' => 'John',
            'username' => 'john',
            'email' => 'john@test.com',
            'password' => 't3@opst2',
        ];

        $this->json('post', 'api/v1/auth/register', $payload)
            ->assertStatus(422);
    }
}
