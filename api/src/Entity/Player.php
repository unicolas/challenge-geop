<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'gender', type: 'string')]
#[ORM\DiscriminatorMap(['male' => MalePlayer::class, 'female' => FemalePlayer::class])]
abstract class Player
{
    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.ulid_generator')]
    protected ?Ulid $id;

    #[ORM\Column]
    protected string $name;

    #[ORM\Column]
    protected int $ability;

    public function getId(): ?Ulid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAbility(): int
    {
        return $this->ability;
    }

    public function setAbility(int $ability): static
    {
        $this->ability = $ability;

        return $this;
    }
}
