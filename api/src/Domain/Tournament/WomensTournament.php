<?php

declare(strict_types=1);

namespace App\Domain\Tournament;

use App\Domain\Match\MatchInterface;
use App\Domain\Match\WomensMatch;
use App\Domain\Player\AbstractPlayer;
use App\Domain\Player\FemalePlayer;

final class WomensTournament implements TournamentInterface
{
    public function single(AbstractPlayer $player1, AbstractPlayer $player2): WomensMatch
    {
        assert($player1 instanceof FemalePlayer);
        assert($player2 instanceof FemalePlayer);

        return new WomensMatch($player1, $player2);
    }

    public function join(MatchInterface $match1, MatchInterface $match2): WomensMatch
    {
        assert($match1 instanceof WomensMatch);
        assert($match2 instanceof WomensMatch);

        return new WomensMatch($match1->play(), $match2->play());
    }
}
