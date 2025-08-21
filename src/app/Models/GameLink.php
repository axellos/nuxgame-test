<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameLink extends Model
{
    protected $fillable = [
        'token',
        'expires_at',
        'active',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gameRecords(): HasMany
    {
        return $this->hasMany(GameRecord::class);
    }

    #[Scope]
    public function active(Builder $query): void
    {
        $query->where('active', true)
            ->where('expires_at', '>', now());
    }
}
