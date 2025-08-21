<?php

declare(strict_types=1);

namespace App\Services\GameLink;

use Ramsey\Uuid\UuidInterface;

interface LinkTokenGeneratorInterface
{
    public function generate(): UuidInterface;
}
