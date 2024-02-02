<?php

declare(strict_types=1);

namespace Tests\App\Service;

use App\Domain\Player\FemalePlayer;
use App\Domain\Player\MalePlayer;
use App\Service\TournamentPlayerService;
use PHPUnit\Framework\TestCase;

class TournamentPlayerServiceTest extends TestCase
{
    /**
     * @dataProvider malePlayersProvider
     */
    public function testPlaysMensTournament(array $players, int $winner): void
    {
        $result = (new TournamentPlayerService())->playMensTournament($players);

        $this->assertEquals($players[$winner], $result);
    }

    /**
     * @dataProvider femalePlayersProvider
     */
    public function testPlaysWomensTournament(array $players, int $winner): void
    {
        $result = (new TournamentPlayerService())->playWomensTournament($players);

        $this->assertEquals($players[$winner], $result);
    }

    protected function malePlayersProvider(): array
    {
        return [
            '2 players' => [
                [
                    new MalePlayer('Player 1', 58, 30, 12), // score (101, 110)
                    new MalePlayer('Player 2', 60, 22, 28), // score (111, 120)
                ],
                1,
            ],
            '4 players' => [
                [
                    new MalePlayer('Player 1', 58, 30, 12), // score (101, 110)
                    new MalePlayer('Player 2', 60, 22, 28), // score (111, 120)
                    new MalePlayer('Player 3', 58, 35, 27), // score (121, 130)
                    new MalePlayer('Player 4', 50, 12, 28), // score (91, 100)
                ],
                2,
            ],
        ];
    }

    protected function femalePlayersProvider(): array
    {
        return [
            '2 players' => [
                [
                    new FemalePlayer('Player 1', 65, 5), // score (61, 70)
                    new FemalePlayer('Player 2', 58, 10), // score (49, 58)
                ],
                0,
            ],
            '4 players' => [
                [
                    new FemalePlayer('Player 1', 52, 10), // score (43, 52)
                    new FemalePlayer('Player 2', 70, 18), // score (53, 62)
                    new FemalePlayer('Player 3', 78, 39), // score (40, 49)
                    new FemalePlayer('Player 4', 64, 2), // score (63, 72)
                ],
                3,
            ],
        ];
    }
}
