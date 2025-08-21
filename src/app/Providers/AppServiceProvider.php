<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Game\GameService;
use App\Services\Game\GameServiceInterface;
use App\Services\Game\Rules\IntervalWinRule;
use App\Services\GameLink\GameLinkService;
use App\Services\GameLink\GameLinkServiceInterface;
use App\Services\GameLink\LinkTokenGenerator;
use App\Services\GameLink\LinkTokenGeneratorInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(GameLinkServiceInterface::class, GameLinkService::class);

        $this->app->singleton(LinkTokenGeneratorInterface::class, LinkTokenGenerator::class);
        $this->app->singleton(GameServiceInterface::class, GameService::class);
    }

    public function boot(): void
    {
        GameService::registerWinRules(
            IntervalWinRule::make(901, 1000, 0.7),
            IntervalWinRule::make(601, 900, 0.5),
            IntervalWinRule::make(301, 600, 0.3),
            IntervalWinRule::make(1,   300, 0.1),
        );
    }
}
