<?php

declare(strict_types=1);

namespace App\Services\GameLink;

use App\Models\GameLink;
use App\Models\User;

class GameLinkService implements GameLinkServiceInterface
{
    public function __construct(
        private LinkTokenGeneratorInterface $linkTokenGenerator
    ) {}

    public function getLinkForUser(User $user): GameLink
    {
        return $user->gameLinks()->active()->first()
            ?? $this->generate($user);
    }

    public function generate(User $user): GameLink
    {
        return $user->gameLinks()->create([
            'token' => $this->linkTokenGenerator->generate(),
            'expires_at' => now()->addDays(7),
            'active' => true,
        ]);
    }

    public function deactivate(GameLink $link): void
    {
        $link->update(['active' => false]);
    }
}
