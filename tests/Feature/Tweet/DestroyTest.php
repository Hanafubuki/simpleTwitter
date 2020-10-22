<?php

namespace Tests\Feature\Tweet;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDestroyTweet()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
