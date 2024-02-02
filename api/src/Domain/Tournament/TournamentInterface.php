<?php

declare(strict_types=1);

namespace App\Domain\Tournament;

use App\Domain\Match\MatchInterface;
use App\Domain\Player\AbstractPlayer;

interface TournamentInterface
{
    /**
     * Builds a single match.
     */
    public function single(AbstractPlayer $player1, AbstractPlayer $player2): MatchInterface;

    /**
     * Joins matches.
     */
    public function join(MatchInterface $match1, MatchInterface $match2): MatchInterface;
}
