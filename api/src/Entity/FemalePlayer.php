<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class FemalePlayer extends Player
{
    #[ORM\Column]
    private int $recoveryTime;

    public function getRecoveryTime(): int
    {
        return $this->recoveryTime;
    }

    public function setRecoveryTime(int $recoveryTime): static
    {
        $this->recoveryTime = $recoveryTime;

        return $this;
    }
}
