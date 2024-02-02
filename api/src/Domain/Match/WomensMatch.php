<?php

declare(strict_types=1);

namespace App\Domain\Match;

use App\Domain\Player\FemalePlayer;

final class WomensMatch implements MatchInterface
{
    public function __construct(
        private readonly FemalePlayer $player1,
        private readonly FemalePlayer $player2
    ) {}

    public function play(): FemalePlayer
    {
        $scorePlayer1 = $this->scoreForPlayer($this->player1);
        $scorePlayer2 = $this->scoreForPlayer($this->player2);

        return match ($scorePlayer1 <=> $scorePlayer2) {
            1 => $this->player1,
            -1 => $this->player2,
            0 => $this->randomPlayer(),
        };
    }

    private function scoreForPlayer(FemalePlayer $player): int
    {
        $luck = rand(1, 10);

        return $player->ability + $luck - $player->recoveryTime;
    }

    private function randomPlayer(): FemalePlayer
    {
        return [$this->player1, $this->player2][rand(0, 1)];
    }
}
