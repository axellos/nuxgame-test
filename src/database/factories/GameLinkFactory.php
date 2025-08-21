<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GameLinkFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'token' => Str::uuid(),
            'is_active' => true,
            'expires_at' => $this->faker->dateTimeBetween('+1 days', '+7 days'),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function expiresAt(DateTimeInterface $date): static
    {
        return $this->state(fn(array $attributes) => [
            'expires_at' => $date,
        ]);
    }
}
