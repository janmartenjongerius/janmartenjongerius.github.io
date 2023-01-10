<?php

declare(strict_types=1);

namespace App\Type;

use BackedEnum;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

abstract class AbstractEnumType extends Type
{
    public function getSQLDeclaration(
        array $column,
        AbstractPlatform $platform
    ): string {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue(
        $value,
        AbstractPlatform $platform
    ): ?string {
        return $value instanceof BackedEnum ? $value->value : null;
    }

    public function convertToPHPValue(
        $value,
        AbstractPlatform $platform
    ): ?BackedEnum {
        return is_string($value)
            ? self::createPHPValue($value)
            : null;
    }

    abstract protected static function createPHPValue(string $value): ?BackedEnum;
}
