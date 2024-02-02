<?php

declare(strict_types=1);

namespace App\Domain\Player;

abstract readonly class AbstractPlayer
{
    protected function __construct(
        public string $name,
        public int $ability
    ) {}
}
