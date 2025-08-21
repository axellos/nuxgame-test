<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\GameLink;
use App\Models\User;

interface GameLinkServiceInterface
{
    public function getLinkForUser(User $user): GameLink;

    public function generate(User $user): GameLink;

    public function deactivate(GameLink $link): void;
}
