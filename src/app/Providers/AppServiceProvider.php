<?php

namespace App\Providers;

use App\Contracts\GameLinkServiceInterface;
use App\Contracts\LinkTokenGeneratorInterface;
use App\Services\GameLinkService;
use App\Services\LinkTokenGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(GameLinkServiceInterface::class, GameLinkService::class);
        $this->app->bind(LinkTokenGeneratorInterface::class, LinkTokenGenerator::class);
    }
}
