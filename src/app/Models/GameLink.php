<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GameLink extends Model
{
    protected $fillable = [
        'token',
        'expires_at',
        'active',
    ];

    #[Scope]
    public function active(Builder $query): void
    {
        $query->where('active', true)
            ->where('expires_at', '>', now());
    }
}
