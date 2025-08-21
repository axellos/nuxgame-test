<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\GameLink;
use App\Services\GameLink\GameLinkServiceInterface;

class GameLinkObserver
{
    public function updated(GameLink $gameLink): void
    {
       app(GameLinkServiceInterface::class)->invalidateCache((string) $gameLink->token);
    }
}
