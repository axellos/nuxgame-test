<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\GameLink;
use App\Services\Game\GameServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GameController extends Controller
{
    public function __construct(
        private readonly GameServiceInterface $gameService,
    ) {}

    public function show(Request $request): View
    {
        /** @var GameLink $gameLink */
        $gameLink = $request->input('gameLink');

        return view('game', ['user' => $gameLink->user, 'token' => $gameLink->token]);
    }

    public function play(Request $request): RedirectResponse
    {
        $record = $this->gameService->play($request->input('gameLink'));

        return redirect()->route('game.page', $request->route('token'))
            ->with('gameResult', $record);
    }

    public function history(Request $request)
    {
        //TODO: Add implementation
    }
}
