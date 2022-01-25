<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    /**
     * Test all login.
     *
     * @return void
     */
    public function testRequiresUsernameAndLogin()
    {
        $this->json('POST', 'api/v1/auth/login')
            ->assertStatus(422);
    }


    public function testRequiresExistentUsername()
    {
        $payload = [
          'username' => 'test_login',
          'password' => Hash::make('p4ssw@'),
        ];
        $this->json('POST', 'api/v1/auth/login', $payload)
            ->assertStatus(404)
            ->assertJson([
                'message' => 'Resource not found',
                'data' => null,
            ]);
    }


    public function testUserLoginsSuccessfully()
    {
        $faker = \Faker\Factory::create();
        $username = $faker->userName;
        \App\Models\User::factory()->create([
          'username' => $username,
          'password' => Hash::make('p4ssw@'),
        ]);

        $payload = ['username' => $username, 'password' => 'p4ssw@'];

        $this->json('POST', 'api/v1/auth/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'token',
            ]);

    }
}
