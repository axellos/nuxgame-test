<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\GameLink;
use App\Models\User;
use App\Services\GameLink\GameLinkServiceInterface;
use Illuminate\Support\Facades\Cache;
use ReflectionClass;
use Tests\TestCase;

class GameLinkServiceTest extends TestCase
{
    protected GameLinkServiceInterface $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(GameLinkServiceInterface::class);
    }

    public function test_it_generates_new_link_for_user(): void
    {
        $user = User::factory()->create();

        $link = $this->service->generate($user);

        $this->assertInstanceOf(GameLink::class, $link);
        $this->assertTrue($link->is_active);
        $this->assertNotEmpty($link->token);
        $this->assertEquals($user->id, $link->user_id);
    }

    public function test_it_returns_link_from_cache_if_exists(): void
    {
        $user = User::factory()->create();
        $link = GameLink::factory()->make([
            'user_id' => $user->id,
            'is_active' => true,
            'expires_at' => now()->addHour(),
        ]);

        Cache::put($this->getCacheKey((string) $link->token), $link, 600);

        $result = $this->service->getLinkByToken((string) $link->token);

        $this->assertSame($link->id, $result->id);
    }

    public function test_it_returns_link_from_db_and_puts_into_cache(): void
    {
        $user = User::factory()->create();
        $link = GameLink::factory()->create([
            'user_id' => $user->id,
            'is_active' => true,
            'expires_at' => now()->addMinutes(30),
        ]);

        $cacheKey = $this->getCacheKey((string) $link->token);

        $this->assertFalse(Cache::has($cacheKey));

        $result = $this->service->getLinkByToken((string) $link->token);

        $this->assertSame($link->id, $result->id);
        $this->assertTrue(Cache::has($cacheKey));
    }

    public function test_it_returns_fake_link_if_token_not_found(): void
    {
        $token = 'non-existing-token';

        $result = $this->service->getLinkByToken($token);

        $this->assertEquals($token, $result->token);
        $this->assertFalse($result->is_active);
        $this->assertTrue(Cache::has($this->getCacheKey($token)));
    }

    public function test_it_can_deactivate_link(): void
    {
        $user = User::factory()->create();
        $link = $this->service->generate($user);

        $link->update(['is_active' => false]);
        $this->assertFalse($link->refresh()->is_active);
    }

    private function getCacheKey(string $token): string
    {
        $reflection = new ReflectionClass($this->service);
        $method = $reflection->getMethod('getCacheKey');

        return $method->invoke($this->service, $token);
    }
}
