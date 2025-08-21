<?php

declare(strict_types=1);

namespace App\Services\Game\Rules;

interface WinRule
{
    public function supports(int $number): bool;
    public function calculate(int $number): int;
}
