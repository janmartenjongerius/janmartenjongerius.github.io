<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\SkillInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('skill')]
final class SkillComponent
{
    private SkillInterface $skill;

    public function mount(SkillInterface $skill): void
    {
        $this->skill = $skill;
    }

    /** @noinspection PhpUnused */
    public function getSkill(): SkillInterface
    {
        return $this->skill;
    }
}
