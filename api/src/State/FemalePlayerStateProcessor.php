<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Domain\Player\FemalePlayer;
use App\Dto\FemalePlayerCollectionDto;
use App\Entity\FemalePlayer as FemalePlayerEntity;
use App\Entity\TournamentResult;
use App\Service\TournamentPlayerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * @implements ProcessorInterface<TournamentResult>
 */
class FemalePlayerStateProcessor implements ProcessorInterface
{
    /** 
     * @param ProcessorInterface<TournamentResult> $persistProcessor
     */
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private TournamentPlayerInterface $tournamentPlayer
    ) {}

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): TournamentResult {
        assert($data instanceof FemalePlayerCollectionDto);

        $players = $this->mapDtoToDomain($data);
        $winner = $this->tournamentPlayer->playWomensTournament($players);
        $tournamentResult = $this->mapDomainToEntity($winner);

        return $this->persistProcessor->process(
            $tournamentResult,
            $operation,
            $uriVariables,
            $context
        );
    }

    /**
     * @return array<FemalePlayer>
     */
    private function mapDtoToDomain(FemalePlayerCollectionDto $dto): array
    {
        return array_map(fn ($player) => new FemalePlayer(
            $player['name'],
            $player['ability'],
            $player['recoveryTime'],
        ), $dto->players);
    }

    private function mapDomainToEntity(FemalePlayer $player): TournamentResult
    {
        $playerEntity = (new FemalePlayerEntity())
            ->setName($player->name)
            ->setAbility($player->ability)
            ->setRecoveryTime($player->recoveryTime);
        $tournamentEntity = (new TournamentResult())
            ->setType(TournamentResult::TYPE_FEMALE)
            ->setDate(new \DateTime('today'))
            ->setWinner($playerEntity);

        return $tournamentEntity;
    }
}
