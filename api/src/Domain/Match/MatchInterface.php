<?php

declare(strict_types=1);

namespace App\Domain\Match;

use App\Domain\Player\AbstractPlayer;

interface MatchInterface
{
    /**
     * Returns the winner of the match.
     */
    public function play(): AbstractPlayer;
}
