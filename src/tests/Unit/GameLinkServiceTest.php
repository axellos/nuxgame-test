<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\GameLink;
use App\Models\User;
use App\Services\GameLink\GameLinkService;
use App\Services\GameLink\LinkTokenGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameLinkServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_generates_new_link_for_user(): void
    {
        $user = User::factory()->create();
        $service = new GameLinkService(new LinkTokenGenerator());

        $link = $service->generate($user);

        $this->assertInstanceOf(GameLink::class, $link);
        $this->assertTrue($link->active);
        $this->assertNotEmpty($link->token);
        $this->assertEquals($user->id, $link->user_id);
    }

    public function test_it_returns_existing_active_link(): void
    {
        $user = User::factory()->create();
        $service = new GameLinkService(new LinkTokenGenerator());
        $existingLink = $service->generate($user);

        $link = $service->getLinkForUser($user);

        $this->assertEquals($existingLink->id, $link->id);
    }

    public function test_it_can_deactivate_link(): void
    {
        $user = User::factory()->create();
        $service = new GameLinkService(new LinkTokenGenerator());
        $link = $service->generate($user);

        $link->update(['active' => false]);
        $this->assertFalse($link->refresh()->active);
    }
}
