<?php

declare(strict_types=1);

namespace App\Service;

use App\Domain\Match\MatchInterface;
use App\Domain\Match\MensMatch;
use App\Domain\Match\WomensMatch;
use App\Domain\Player\AbstractPlayer;
use App\Domain\Player\FemalePlayer;
use App\Domain\Player\MalePlayer;
use App\Domain\Tournament\MensTournament;
use App\Domain\Tournament\TournamentInterface;
use App\Domain\Tournament\WomensTournament;

class TournamentPlayerService implements TournamentPlayerInterface
{
    public function playMensTournament(array $players): MalePlayer
    {
        /** @var MensMatch $game */
        $game = $this->drawTournament($players, new MensTournament());

        return $game->play();
    }

    public function playWomensTournament(array $players): FemalePlayer
    {
        /** @var WomensMatch $game */
        $game = $this->drawTournament($players, new WomensTournament());

        return $game->play();
    }

    /**
     * Draw the matches of the tournament for the given players.
     * 
     * @param array<AbstractPlayer> $players
     */
    private function drawTournament(
        array $players,
        TournamentInterface $tournament
    ): MatchInterface {
        $numberOfPlayers = count($players);
        if (2 === $numberOfPlayers) {
            return $tournament->single($players[0], $players[1]);
        }
        [$left, $right] = array_chunk($players, intdiv($numberOfPlayers, 2));

        return $tournament->join(
            $this->drawTournament($left, $tournament),
            $this->drawTournament($right, $tournament)
        );
    }
}
