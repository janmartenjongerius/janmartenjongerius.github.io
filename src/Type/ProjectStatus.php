<?php

declare(strict_types=1);

namespace App\Type;

use App\Enum\ProjectStatus as ProjectStatusEnum;

final class ProjectStatus extends AbstractEnumType
{
    public const NAME = 'project_status';

    public function getName(): string
    {
        return self::NAME;
    }

    protected static function createPHPValue(string $value): ?ProjectStatusEnum
    {
        return ProjectStatusEnum::tryFrom($value);
    }
}
