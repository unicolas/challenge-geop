<?php

declare(strict_types=1);

namespace App\Service;

use App\Domain\Player\FemalePlayer;
use App\Domain\Player\MalePlayer;

interface TournamentPlayerInterface
{
    /**
     * Plays a men's tournament with the given male players.
     * 
     * @param array<MalePlayer> $players
     */
    public function playMensTournament(array $players): MalePlayer;

    /**
     * Plays a women's tournament with the given female players.
     * 
     * @param array<FemalePlayer> $players
     */
    public function playWomensTournament(array $players): FemalePlayer;
}
