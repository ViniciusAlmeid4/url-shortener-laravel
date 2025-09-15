<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase {
    /**
     * A basic feature test example.
     */
    public function correct_credentials(): void {
        // // Arrange: create a user
        // $user = \App\Models\User::factory()->create([
        //     'email' => 'teste@gmail.com',
        //     'password' => bcrypt('password123'),
        // ]);

        // $response = $this->post('/login', [
        //     'email' => $user->email,
        //     'password' => 'password123',
        // ]);

        // $response->assertStatus(200);
    }
}
