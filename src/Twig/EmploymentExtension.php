<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Employment;
use DateTimeImmutable;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Contracts\Translation\TranslatableInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class EmploymentExtension extends AbstractExtension
{
    public const TRANSLATION_EMPLOYMENT_DURATION = 'employment.duration';

    public function getFilters(): array
    {
        return [
            new TwigFilter('duration', $this->formatDuration(...))
        ];
    }

    public function formatDuration(Employment $employment): TranslatableInterface
    {
        $duration = ($employment->getEndAt() ?? new DateTimeImmutable())->diff(
            $employment->getStartAt()
        );

        return new TranslatableMessage(
            self::TRANSLATION_EMPLOYMENT_DURATION,
            [
                '%years%' => $duration->y,
                '%months%' => $duration->m
            ]
        );
    }
}
