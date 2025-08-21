<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\LinkTokenGeneratorInterface;
use Illuminate\Support\Str;
use Ramsey\Uuid\UuidInterface;

class LinkTokenGenerator implements LinkTokenGeneratorInterface
{
    public function generate(): UuidInterface
    {
        return Str::uuid();
    }
}
