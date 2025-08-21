<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'username' => fake()->name(),
            'phone_number' => fake()->phoneNumber(),
        ];
    }
}
