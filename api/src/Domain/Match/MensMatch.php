<?php

declare(strict_types=1);

namespace App\Domain\Match;

use App\Domain\Player\MalePlayer;

final class MensMatch implements MatchInterface
{
    public function __construct(
        private readonly MalePlayer $player1,
        private readonly MalePlayer $player2
    ) {}

    public function play(): MalePlayer
    {
        $scorePlayer1 = $this->scoreForPlayer($this->player1);
        $scorePlayer2 = $this->scoreForPlayer($this->player2);

        return match ($scorePlayer1 <=> $scorePlayer2) {
            1 => $this->player1,
            -1 => $this->player2,
            0 => $this->randomPlayer(),
        };
    }

    private function scoreForPlayer(MalePlayer $player): int
    {
        $luck = rand(1, 10);

        return $player->ability + $luck + $player->strength + $player->speed;
    }

    private function randomPlayer(): MalePlayer
    {
        return [$this->player1, $this->player2][rand(0, 1)];
    }
}
