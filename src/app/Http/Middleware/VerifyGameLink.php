<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\GameLink\GameLinkServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyGameLink
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->route('token');

        $gameLink = app(GameLinkServiceInterface::class)->getLinkByToken($token);

        if (!$gameLink->isValid()) {
            return redirect()->route('register.page');
        }

        $request->merge(['gameLink' => $gameLink]);

        return $next($request);
    }
}
