<?php

declare(strict_types=1);

namespace App\Services\Game\Rules;

readonly class IntervalWinRule implements WinRule
{
    public function __construct(
        private int $min,
        private int $max,
        private float $multiplier,
    ) {}

    public static function make(int $min, int $max, float $multiplier): static
    {
        return new static($min, $max, $multiplier);
    }

    public function supports(int $number): bool
    {
        return $number >= $this->min && $number <= $this->max;
    }

    public function calculate(int $number): int
    {
        return (int) round($number * $this->multiplier);
    }
}
