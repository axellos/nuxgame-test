<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\GameLink;
use App\Models\GameRecord;
use App\Services\Game\GameService;
use Tests\TestCase;

class GameServiceTest extends TestCase
{
    public function test_play_creates_game_record(): void
    {
        $link = GameLink::factory()->create();
        $service = new GameService();

        $record = $service->play($link);

        $this->assertInstanceOf(GameRecord::class, $record);
        $this->assertEquals($link->id, $record->game_link_id);
        $this->assertGreaterThanOrEqual(1, $record->number);
        $this->assertLessThanOrEqual(1000, $record->number);
    }
}
