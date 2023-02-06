<?php

declare(strict_types=1);

namespace App\Twig;
trait HtmlAttributesTrait
{
    private static function getHtmlAttributes(array $attributes): string
    {
        $result = [];
        $candidates = array_filter(
            $attributes,
            static fn ($value) => !is_null($value)
        );

        foreach ($candidates as $attribute => $value) {
            $result[] = sprintf(
                '%s="%s"',
                htmlentities((string)$attribute),
                htmlentities((string)$value)
            );
        }

        return implode(' ', $result);
    }
}
