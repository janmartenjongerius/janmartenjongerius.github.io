<?php

declare(strict_types=1);

namespace App\Twig;

use League\CommonMark\ConverterInterface;
use League\CommonMark\GithubFlavoredMarkdownConverter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class MarkdownExtension extends AbstractExtension
{
    private const MARKDOWN_OPTIONS = [];

    public function __construct(
        private readonly ConverterInterface $converter = new GithubFlavoredMarkdownConverter(
            self::MARKDOWN_OPTIONS
        )
    ) {}

    public function getFilters(): iterable
    {
        yield new TwigFilter(
            'markdown',
            $this->converter->convert(...),
            [
                'is_safe' => ['html']
            ]
        );
    }
}
