<?php

declare(strict_types=1);

namespace App\Services\GameLink;

use App\Models\GameLink;
use App\Models\User;

interface GameLinkServiceInterface
{
    public function getLinkByToken(string $token): GameLink;

    public function generate(User $user): GameLink;

    public function deactivate(GameLink $link): void;

    public function invalidateCache(string $token): void;
}
