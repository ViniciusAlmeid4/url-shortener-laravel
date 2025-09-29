<?php

namespace test\Feature;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Support\Str;

class ShortUrlTest extends TestCase {
    use RefreshDatabase;

    private User $user;
    private array $urls;

    protected function setUp(): void {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'teste@gmail.com',
            'password' => Hash::make('secret123')
        ]);

        $this->urls = [];

        $this->urls[] = ShortUrl::factory()->create([
            'original' => 'https://www.google.com',
            'user_id' => $this->user->id,
            'code' => Str::random(10),
            'clicks' => 0,
            'is_active' => true
        ]);

        $this->urls[] = ShortUrl::factory()->create([
            'original' => "https://www.youtube.com",
            'user_id' => $this->user->id,
            'code' => Str::random(10),
            'clicks' => 0,
            'is_active' => true
        ]);
    }

    #[Test]
    public function getUrls(): void {
        $urls = $this->user->shortUrls;

        $this->assertTrue($urls->contains($this->urls[0]));
        $this->assertTrue($urls->contains($this->urls[1]));
    }

    #[Test]
    public function unloggedShortUrlsPageRender(): void {
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirectToRoute('login');
    }

    #[Test]
    public function loggedShortUrlsPageRender(): void {
        $this->actingAs($this->user);
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('home');
    }

    #[Test]
    public function createShortUrl(): void {
        $this->actingAs($this->user);
        $response = $this->postJson('/shorten', [
            'urlInput' => 'https://www.google.com',
            'password' => '123'
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'message',
            'id',
            'shortened',
            'original',
            'created_at',
            'code'
        ]);
    }

    #[Test]
    public function createShortUrlWhithMissingUrlInput(): void {
        $this->actingAs($this->user);
        $response = $this->postJson('/shorten', []);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(["urlInput"]);
    }

    #[Test]
    public function destroyUrl(): void {
        $this->actingAs($this->user);
        $response = $this->delete("/shorten/{$this->urls[0]->code}");

        $response->assertStatus(200);
    }

    #[Test]
    public function destroyUrlUnauthenticated(): void {
        $this->actingAsGuest();
        $response = $this->delete("/shorten/{$this->urls[0]->code}");

        $response->assertStatus(403);
    }
}
