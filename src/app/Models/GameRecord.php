<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\GameStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameRecord extends Model
{
    protected $fillable = [
        'number',
        'status',
        'win_amount',
    ];

    protected $casts = [
        'status' => GameStatus::class,
    ];

    public function gameLink(): BelongsTo
    {
        return $this->belongsTo(GameLink::class);
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status->label()
        );
    }
}
