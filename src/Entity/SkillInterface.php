<?php

declare(strict_types=1);

namespace App\Entity;

use Stringable;

interface SkillInterface extends Stringable
{
    public function getName(): ?string;

    public function getDescription(): ?string;
}
