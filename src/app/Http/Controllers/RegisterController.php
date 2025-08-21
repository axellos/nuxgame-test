<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\GameLink\GameLinkServiceInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    public function __construct(
        protected GameLinkServiceInterface $gameLinkService
    ) {}

    public function show(): View
    {
        return view('register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::query()->firstOrCreate(
            ['phone_number' => $request->validated('phone_number')],
            ['username' => $request->validated('username')],
        );

        $link = $this->gameLinkService->getLinkForUser($user);

        return redirect()->route('register.page')
            ->with('gameLink', route('game.page', ['token' => $link->token]));
    }
}
