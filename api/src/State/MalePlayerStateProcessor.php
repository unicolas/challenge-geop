<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Domain\Player\MalePlayer;
use App\Dto\MalePlayerCollectionDto;
use App\Entity\MalePlayer as MalePlayerEntity;
use App\Entity\TournamentResult;
use App\Service\TournamentPlayerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * @implements ProcessorInterface<TournamentResult>
 */
class MalePlayerStateProcessor implements ProcessorInterface
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
        assert($data instanceof MalePlayerCollectionDto);

        $players = $this->mapDtoToDomain($data);
        $winner = $this->tournamentPlayer->playMensTournament($players);
        $tournamentResult = $this->mapDomainToEntity($winner);

        return $this->persistProcessor->process(
            $tournamentResult,
            $operation,
            $uriVariables,
            $context
        );
    }

    /**
     * @return array<MalePlayer>
     */
    private function mapDtoToDomain(MalePlayerCollectionDto $dto): array
    {
        return array_map(fn ($player) => new MalePlayer(
            $player['name'],
            $player['ability'],
            $player['strength'],
            $player['speed'],
        ), $dto->players);
    }

    private function mapDomainToEntity(MalePlayer $player): TournamentResult
    {
        /** @var MalePlayerEntity $playerEntity */
        $playerEntity = (new MalePlayerEntity())
            ->setName($player->name)
            ->setAbility($player->ability)
            ->setStrength($player->strength)
            ->setSpeed($player->speed);
        $tournamentEntity = (new TournamentResult())
            ->setType(TournamentResult::TYPE_MALE)
            ->setDate(new \DateTime('today'))
            ->setWinner($playerEntity);

        return $tournamentEntity;
    }
}
