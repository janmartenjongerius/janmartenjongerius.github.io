<?php

declare(strict_types=1);

namespace App\Twig;

use Stringable;

final readonly class Asset implements Stringable
{
    private ?string $content;

    public function __construct(private string $path)
    {
    }

    public function __toString(): string
    {
        return $this->content ??= file_get_contents($this->path);
    }
}
