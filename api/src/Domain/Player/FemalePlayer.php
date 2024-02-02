<?php

declare(strict_types=1);

namespace App\Domain\Player;

readonly class FemalePlayer extends AbstractPlayer
{
    public function __construct(
        string $name,
        int $ability,
        public int $recoveryTime
    ) {
        parent::__construct($name, $ability);
    }
}
