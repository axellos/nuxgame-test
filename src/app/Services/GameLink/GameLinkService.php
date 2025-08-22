<?php

declare(strict_types=1);

namespace App\Services\GameLink;

use App\Models\GameLink;
use App\Models\User;
use Illuminate\Cache\CacheManager;

readonly class GameLinkService implements GameLinkServiceInterface
{
    public function __construct(
        private CacheManager $cacheManager,
        private LinkTokenGeneratorInterface $linkTokenGenerator
    ) {}

    public function getLinkByToken(string $token): GameLink
    {
        $cacheKey = $this->getCacheKey($token);

        $cachedLink = $this->cacheManager->get($cacheKey);

        if ($cachedLink) {
            return $cachedLink;
        }

        $link = GameLink::query()->where('token', $token)->active()->first()
            ?? $this->makeFakeLinkForUnknownToken($token);

        $ttlSeconds = now()->diffInSeconds($link->expires_at);
        $ttlSeconds = max($ttlSeconds, 60);

        $this->cacheManager->put($cacheKey, $link, $ttlSeconds);

        return $link;
    }

    public function generate(User $user): GameLink
    {
        return $user->gameLinks()->create([
            'token' => $this->linkTokenGenerator->generate(),
            'expires_at' => now()->addMinutes(config('game.link_expiration_minutes')),
            'is_active' => true,
        ]);
    }

    public function deactivate(GameLink $link): void
    {
        $link->update(['is_active' => false]);
    }

    public function invalidateCache(string $token): void
    {
        $this->cacheManager->forget($this->getCacheKey($token));
    }

    private function makeFakeLinkForUnknownToken(string $token): GameLink
    {
        return GameLink::query()->make([
            'token' => $token,
            'is_active' => false,
            'expires_at' => now()->addSeconds(120),
        ]);
    }

    private function getCacheKey(string $token): string
    {
        return "{$token}:game_link";
    }
}
