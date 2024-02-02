<?php

declare(strict_types=1);

namespace App\Domain\Tournament;

use App\Domain\Match\MatchInterface;
use App\Domain\Match\MensMatch;
use App\Domain\Player\AbstractPlayer;
use App\Domain\Player\MalePlayer;

final class MensTournament implements TournamentInterface
{
    public function single(AbstractPlayer $player1, AbstractPlayer $player2): MensMatch
    {
        assert($player1 instanceof MalePlayer);
        assert($player2 instanceof MalePlayer);

        return new MensMatch($player1, $player2);
    }

    public function join(MatchInterface $match1, MatchInterface $match2): MensMatch
    {
        assert($match1 instanceof MensMatch);
        assert($match2 instanceof MensMatch);

        return new MensMatch($match1->play(), $match2->play());
    }
}
