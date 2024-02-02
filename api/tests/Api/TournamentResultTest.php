<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\FemalePlayer;
use App\Entity\MalePlayer;
use App\Entity\TournamentResult;

class TournamentResultTest extends ApiTestCase
{
    public function testRunsMensTournament(): void
    {
        static::createClient()->request('POST', '/tournaments/mens', [
            'json' => [
                'players' => [
                    [
                        'name' => 'Player 1',
                        'ability' => 58,
                        'strength' => 30,
                        'speed' => 12,
                    ],
                    [
                        'name' => 'Player 2',
                        'ability' => 60,
                        'strength' => 22,
                        'speed' => 28,
                    ],
                    [
                        'name' => 'Player 3',
                        'ability' => 58,
                        'strength' => 35,
                        'speed' => 27,
                    ],
                    [
                        'name' => 'Player 4',
                        'ability' => 50,
                        'strength' => 12,
                        'speed' => 28,
                    ],
                ],
            ],
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            'type' => 'male',
            'winner' => [
                'name' => 'Player 3',
                'ability' => 58,
                'strength' => 35,
                'speed' => 27,
            ],
        ]);
    }

    /**
     * @dataProvider invalidMalePlayersProvider
     */
    public function testDoesNotRunMensTournamentGivenInvalidPlayers(array $players): void
    {
        static::createClient()->request('POST', '/tournaments/mens', [
            'json' => [
                'players' => $players,
            ],
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(422);
    }

    protected function invalidMalePlayersProvider(): array
    {
        return [
            'Missing name' => [[
                [
                    'ability' => 58,
                    'strength' => 30,
                    'speed' => 12,
                ],
                [
                    'name' => 'Player 2',
                    'ability' => 60,
                    'strength' => 22,
                    'speed' => 28,
                ],
            ]],
            'Missing ability' => [[
                [
                    'name' => 'Player 1',
                    'ability' => 58,
                    'strength' => 30,
                    'speed' => 12,
                ],
                [
                    'name' => 'Player 2',
                    'strength' => 22,
                    'speed' => 28,
                ],
            ]],
            'Missing strength' => [[
                [
                    'name' => 'Player 1',
                    'ability' => 58,
                    'strength' => 30,
                    'speed' => 12,
                ],
                [
                    'name' => 'Player 2',
                    'ability' => 60,
                    'speed' => 28,
                ],
            ]],
            'Missing speed' => [[
                [
                    'name' => 'Player 1',
                    'ability' => 58,
                    'strength' => 30,
                ],
                [
                    'name' => 'Player 2',
                    'ability' => 60,
                    'strength' => 22,
                    'speed' => 28,
                ],
            ]],
            'All missing' => [[
                [],
                [
                    'name' => 'Player 2',
                    'ability' => 60,
                    'strength' => 22,
                    'speed' => 28,
                ],
            ]],
            'Female player' => [[
                [
                    'name' => 'Player 2',
                    'ability' => 60,
                    'recoveryTime' => 22,
                ],
                [
                    'name' => 'Player 2',
                    'ability' => 60,
                    'strength' => 22,
                    'speed' => 28,
                ],
            ]],
            'Odd number of players' => [[
                [
                    'name' => 'Player 1',
                    'ability' => 58,
                    'strength' => 30,
                    'speed' => 12,
                ],
            ]],
        ];
    }

    public function testRunsWomensTournament(): void
    {
        static::createClient()->request('POST', '/tournaments/womens', [
            'json' => [
                'players' => [
                    [
                        'name' => 'Player 1',
                        'ability' => 52,
                        'recoveryTime' => 10,
                    ],
                    [
                        'name' => 'Player 2',
                        'ability' => 70,
                        'recoveryTime' => 18,
                    ],
                    [
                        'name' => 'Player 3',
                        'ability' => 78,
                        'recoveryTime' => 39,
                    ],
                    [
                        'name' => 'Player 4',
                        'ability' => 64,
                        'recoveryTime' => 2,
                    ],
                ],
            ],
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            'type' => 'female',
            'winner' => [
                'name' => 'Player 4',
                'ability' => 64,
                'recoveryTime' => 2,
            ],
        ]);
    }

    /**
     * @dataProvider invalidFemalePlayersProvider
     */
    public function testDoesNotRunWomensTournamentGivenInvalidPlayers(array $players): void
    {
        static::createClient()->request('POST', '/tournaments/mens', [
            'json' => [
                'players' => $players,
            ],
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(422);
    }

    protected function invalidFemalePlayersProvider(): array
    {
        return [
            'Missing name' => [[
                [
                    'name' => 'Player 1',
                    'ability' => 52,
                    'recoveryTime' => 10,
                ],
                [
                    'ability' => 70,
                    'recoveryTime' => 18,
                ],
            ]],
            'Missing ability' => [[
                [
                    'name' => 'Player 1',
                    'recoveryTime' => 10,
                ],
                [
                    'name' => 'Player 2',
                    'ability' => 70,
                    'recoveryTime' => 18,
                ],
            ]],
            'Missing recovery time' => [[
                [
                    'name' => 'Player 1',
                    'ability' => 52,
                    'recoveryTime' => 10,
                ],
                [
                    'name' => 'Player 2',
                    'ability' => 70,
                ],
            ]],
            'All missing' => [[
                [
                    'name' => 'Player 1',
                    'ability' => 52,
                    'recoveryTime' => 10,
                ],
                [],
            ]],
            'Male player' => [[
                [
                    'name' => 'Player 1',
                    'ability' => 52,
                    'recoveryTime' => 10,
                ],
                [
                    'name' => 'Player 2',
                    'ability' => 60,
                    'strength' => 22,
                    'speed' => 28,
                ],
            ]],
            'Odd number of players' => [[
                [
                    'name' => 'Player 1',
                    'ability' => 52,
                    'recoveryTime' => 10,
                ],
            ]],
        ];
    }

    public function testRetrievesAllTournaments(): void
    {
        $client = static::createClient();
        $this->givenMensAndWomensTournaments();

        $response = $client->request('GET', '/tournaments');

        $tournaments = $response->toArray()['hydra:member'];
        $this->assertResponseStatusCodeSame(200);
        $this->assertTrue(count($tournaments) >= 2);
        $this->assertIncludesMensTournament($tournaments, '2024-01-31', 'Player 3', 58, 35, 27);
        $this->assertIncludesWomensTournament($tournaments, '2024-02-01', 'Player 4', 64, 2);
    }

    public function testRetrievesMensTournaments(): void
    {
        $client = static::createClient();
        $this->givenMensAndWomensTournaments();

        $response = $client->request('GET', '/tournaments?type=male');

        $tournaments = $response->toArray()['hydra:member'];
        $this->assertResponseStatusCodeSame(200);
        $this->assertTrue(count($tournaments) >= 1);
        $this->assertAllMensTournaments($tournaments);
    }

    public function testRetrievesWomensTournaments(): void
    {
        $client = static::createClient();
        $this->givenMensAndWomensTournaments();

        $response = $client->request('GET', '/tournaments?type=female');

        $tournaments = $response->toArray()['hydra:member'];
        $this->assertResponseStatusCodeSame(200);
        $this->assertTrue(count($tournaments) >= 1);
        $this->assertAllWomensTournaments($tournaments);
    }

    public function testRetrievesTournamentsByDate(): void
    {
        $client = static::createClient();
        $this->givenMensAndWomensTournaments();

        $response = $client->request('GET', '/tournaments?date=2024-01-31');

        $tournaments = $response->toArray()['hydra:member'];
        $this->assertResponseStatusCodeSame(200);
        $this->assertTrue(count($tournaments) >= 1);
        $this->assertAllTournamentsOnDate($tournaments, '2024-01-31');
    }

    private function givenMensAndWomensTournaments(): void
    {
        $em = static::getContainer()->get('doctrine')->getManager();

        $player = (new MalePlayer())
            ->setName('Player 3')
            ->setAbility(58)
            ->setStrength(35)
            ->setSpeed(27);
        $tournament = (new TournamentResult())
            ->setType(TournamentResult::TYPE_MALE)
            ->setDate(new \DateTime('2024-01-31'))
            ->setWinner($player);
        $em->persist($tournament);

        $player = (new FemalePlayer())
            ->setName('Player 4')
            ->setAbility(64)
            ->setRecoveryTime(2);
        $tournament = (new TournamentResult())
            ->setType(TournamentResult::TYPE_FEMALE)
            ->setDate(new \DateTime('2024-02-01'))
            ->setWinner($player);
        $em->persist($tournament);

        $em->flush();
    }

    private function assertIncludesMensTournament(
        array $tournaments,
        string $date,
        string $name,
        int $ability,
        int $strength,
        int $speed
    ): void {
        $mens = $this->filterBy($tournaments, 'male', $date);
        $found = false;
        foreach ($mens as $men) {
            $found = $men['name'] === $name
                && $men['ability'] === $ability
                && $men['strength'] === $strength
                && $men['speed'] === $speed;
            if ($found) {
                break;
            }
        }
        $this->assertTrue($found);
    }

    private function assertIncludesWomensTournament(
        array $tournaments,
        string $date,
        string $name,
        int $ability,
        int $recoveryTime
    ): void {
        $womens = $this->filterBy($tournaments, 'female', $date);
        $found = false;
        foreach ($womens as $women) {
            $found = $women['name'] === $name
                && $women['ability'] === $ability
                && $women['recoveryTime'] === $recoveryTime;
            if ($found) {
                break;
            }
        }
        $this->assertTrue($found);
    }

    private function assertAllMensTournaments(array $tournaments): void
    {
        $mens = $this->filterBy($tournaments, 'male');

        $this->assertEquals(count($tournaments), count($mens));
    }

    private function assertAllWomensTournaments(array $tournaments): void
    {
        $womens = $this->filterBy($tournaments, 'female');

        $this->assertEquals(count($tournaments), count($womens));
    }

    private function assertAllTournamentsOnDate(array $tournaments, string $date): void
    {
        $onDate = $this->filterBy($tournaments, date: $date);

        $this->assertEquals(count($tournaments), count($onDate));
    }

    private function filterBy(array $tournaments, string $type = null, string $date = null): array
    {
        if (!is_null($type)) {
            $tournaments = array_filter($tournaments, fn ($t) => $t['type'] === $type);
        }
        if (!is_null($date)) {
            $tournaments = array_filter(
                $tournaments,
                fn ($t) => (new \DateTime($t['date']))->format('Y-m-d') === $date
            );
        }

        return array_column($tournaments, 'winner');
    }
}
