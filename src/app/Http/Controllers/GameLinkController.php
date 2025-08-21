<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\GameLinkServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GameLinkController extends Controller
{
    public function __construct(
        private readonly GameLinkServiceInterface $gameLinkService,
    ) {}

    public function generate(Request $request): RedirectResponse
    {
        $newGameLink = $this->gameLinkService->generate($request->input('gameLink')->user);

        return redirect()->route('game.page', $request->route('token'))
            ->with('newGameLink', route('game.page', ['token' => $newGameLink->token]));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $this->gameLinkService->deactivate($request->input('gameLink'));

        return redirect()->route('register.page');
    }
}
