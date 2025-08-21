<?php

declare(strict_types=1);

namespace App\Services\Game;

use App\Models\GameLink;
use App\Models\GameRecord;

interface GameServiceInterface
{
    public function play(GameLink $link): GameRecord;
}
