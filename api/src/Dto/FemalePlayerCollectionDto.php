<?php

declare(strict_types=1);

namespace App\Dto;

use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Validator\Constraints as Assert;

class FemalePlayerCollectionDto
{
    /** @var array<mixed> */
    #[Assert\Count(divisibleBy: 2)]
    #[Assert\All(
        new Assert\Collection([
            'fields' => [
                'name' => new Assert\NotBlank(),
                'ability' => new Assert\Range(min: 0, max: 100),
                'recoveryTime' => new Assert\PositiveOrZero(),
            ],
        ])
    )]
    #[ApiProperty(
        openapiContext: [
            'type' => 'array',
            'items' => [
                'type' => 'object',
                'properties' => [
                    'name' => ['type' => 'string'],
                    'ability' => ['type' => 'integer'],
                    'recoveryTime' => ['type' => 'integer'],
                ],
            ],
        ]
    )]
    public array $players;
}
