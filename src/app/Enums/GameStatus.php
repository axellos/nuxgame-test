<?php

declare(strict_types=1);

namespace App\Enums;

enum GameStatus: string
{
    case WIN = 'win';
    case LOSE = 'lose';

    public function label(): string
    {
        return __("game.status.{$this->value}");
    }
}
