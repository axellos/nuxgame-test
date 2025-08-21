<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\GameLink;
use Illuminate\Http\Response;
use Tests\TestCase;

class VerifyGameLinkTest extends TestCase
{
    public function test_redirects_if_link_not_found(): void
    {
        $response = $this->get("/games/invalid-token");

        $response->assertStatus(Response::HTTP_FOUND);
    }

    public function test_redirects_if_lin_is_deactivated(): void
    {
        $link = GameLink::factory()->inactive()->create();
        $response = $this->get("/games/{$link->token}");

        $response->assertStatus(Response::HTTP_FOUND);
    }

    public function test_allows_request_if_link_is_valid(): void
    {
        $link = GameLink::factory()->create();
        $response = $this->get("/games/{$link->token}");

        $response->assertStatus(Response::HTTP_OK);
    }
}
