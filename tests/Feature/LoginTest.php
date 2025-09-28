<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LoginTest extends TestCase {
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void {
        parent::setUp();

        // create a default test user
        $this->user = User::factory()->create([
            "email" => "test@gmail.com",
            "password" => Hash::make('secret123'),
        ]);
    }

    #[Test]
    public function loginPageRender(): void {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('login');
    }

    #[Test]
    public function loginWithMissingParameters(): void {
        $response = $this->postJson('/login', []);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['email', 'password']);
    }


    #[Test]
    public function loginWithWrongParameters(): void {
        $response = $this->postJson('/login', [
            "email" => "errado@gmail.com",
            "password" => "wrongPassword"
        ]);

        $response->assertStatus(401);

        $response->assertJsonValidationErrors(['email']);

        $response->assertJsonFragment(['email' => true]);
    }

    #[Test]
    public function loginWithCorrectPassworrd(): void {
        $response = $this->postJson('/login', [
            "email" => "test@gmail.com",
            "password" => "secret123"
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            "redirect" => route('home')
        ]);
    }

    #[Test]
    public function loginWithWrongPassworrd(): void {
        $response = $this->postJson('/login', [
            "email" => "test@gmail.com",
            "password" => "wrongPassword"
        ]);

        $response->assertStatus(401);

        $response->assertJsonValidationErrors(['email']);

        $response->assertJsonFragment(['email' => false]);
    }
}
