<?php

namespace test\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RegisterTest extends TestCase {
    use RefreshDatabase;

    #[Test]
    public function createUser(): void {
        $response = $this->postJson('/register', [
            "email" => "teste@gmail.com",
            "password" => "secret123"
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment(["redirect" => route('home')]);
    }

    #[Test]
    public function createUserWithoutParameters(): void {
        $response = $this->postJson('/register', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password']);
    }
}
