<?php

namespace Tests\Unit;

use App\Models\GameLink;
use App\Services\GameLink\GameLinkServiceInterface;
use Mockery;
use Tests\TestCase;

class GameLinkObserverTest extends TestCase
{
    public function test_it_invalidates_cache_on_update(): void
    {
        $mock = Mockery::mock(GameLinkServiceInterface::class);
        $mock->shouldReceive('invalidateCache')
            ->once()
            ->withArgs(function ($token) {
                return ! empty($token);
            });

        $this->app->instance(GameLinkServiceInterface::class, $mock);

        $link = GameLink::factory()->create();

        $link->update(['is_active' => false]);
    }
}
