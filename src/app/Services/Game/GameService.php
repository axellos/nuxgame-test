<?php

declare(strict_types=1);

namespace App\Services\Game;

use App\Enums\GameStatus;
use App\Models\GameLink;
use App\Models\GameRecord;
use App\Services\Game\Rules\WinRule;
use Illuminate\Support\Collection;

class GameService implements GameServiceInterface
{
    protected static array $winRules = [];

    public static function registerWinRules(WinRule ...$rules): void
    {
        static::$winRules = array_merge(static::$winRules, $rules);
    }

    public function play(GameLink $link): GameRecord
    {
        $number = random_int(1, 1000);
        $isWin = $number % 2 === 0;

        $winAmount = $isWin ? $this->calculateWinAmount($number) : 0;

        return $link->gameRecords()->create([
            'number' => $number,
            'status' => $isWin ? GameStatus::WIN : GameStatus::LOSE,
            'win_amount' => $winAmount,
        ]);
    }

    public function getLastResults(GameLink $link, int $limit = 3): Collection
    {
        return $link->gameRecords()
            ->latest()
            ->take($limit)
            ->get();
    }

    protected function calculateWinAmount(int $number): int
    {
        foreach (static::$winRules as $rule) {
            if ($rule->supports($number)) {
                return $rule->calculate($number);
            }
        }

        return 0;
    }
}
