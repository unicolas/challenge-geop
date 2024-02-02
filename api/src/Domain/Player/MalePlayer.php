<?php

declare(strict_types=1);

namespace App\Domain\Player;

readonly class MalePlayer extends AbstractPlayer
{
    public function __construct(
        string $name,
        int $ability,
        public int $strength,
        public int $speed,
    ) {
        parent::__construct($name, $ability);
    }
}
