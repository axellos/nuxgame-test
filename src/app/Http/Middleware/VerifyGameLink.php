<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\GameLink;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyGameLink
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->route('token');

        if (! $token) {
            return redirect()->route('register.page');
        }

        $gameLink = GameLink::query()->where('token', $token)->active()->first();

        if (! $gameLink) {
            return redirect()->route('register.page');
        }

        $request->merge(['gameLink' => $gameLink]);

        return $next($request);
    }
}
