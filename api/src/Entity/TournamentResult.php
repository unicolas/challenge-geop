<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Dto\FemalePlayerCollectionDto;
use App\Dto\MalePlayerCollectionDto;
use App\State\FemalePlayerStateProcessor;
use App\State\MalePlayerStateProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity]
#[ApiResource(
    shortName: 'Tournament',
    operations: [
        new GetCollection(
            uriTemplate: 'tournaments',
            openapiContext: [
                'summary' => 'Retrieves tournaments',
            ],
        ),
        new Post(
            uriTemplate: 'tournaments/mens',
            input: MalePlayerCollectionDto::class,
            processor: MalePlayerStateProcessor::class,
            openapiContext: [
                'summary' => 'Runs a men\'s tournament',
            ],
        ),
        new Post(
            uriTemplate: 'tournaments/womens',
            input: FemalePlayerCollectionDto::class,
            processor: FemalePlayerStateProcessor::class,
            openapiContext: [
                'summary' => 'Runs a women\'s tournament',
            ]
        ),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['type' => 'iexact', 'date' => 'exact'])]
class TournamentResult
{
    public const TYPE_MALE = 'male';
    public const TYPE_FEMALE = 'female';

    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.ulid_generator')]
    protected ?Ulid $id;

    #[ORM\Column]
    private string $type;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $date;

    #[ORM\OneToOne(targetEntity: Player::class, cascade: ['persist'])]
    private Player $winner;

    public function getId(): ?Ulid
    {
        return $this->id;
    }

    public function setId(Ulid $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getWinner(): Player
    {
        return $this->winner;
    }

    public function setWinner(Player $winner): self
    {
        $this->winner = $winner;

        return $this;
    }
}
