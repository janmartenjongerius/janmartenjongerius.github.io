<?php

declare(strict_types=1);

namespace App\Twig;

use RuntimeException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class SvgExtension extends AbstractExtension
{
    private array $symbols = [];

    public function getFunctions(): iterable
    {
        yield new TwigFunction(
            'use',
            $this->getSymbol(...),
            ['is_safe' => ['html']]
        );
        yield new TwigFunction(
            'svg_definitions',
            $this->getSvgDefinitions(...),
            ['is_safe' => ['html']]
        );
    }

    public function getSvgDefinitions(): string
    {
        if (empty($this->symbols)) {
            return '';
        }

        $symbols = [];

        foreach ($this->symbols as $id => $content) {
            $symbols[] = <<<SYMBOL
            <symbol id="$id">
                $content
            </symbol>
            SYMBOL;
        }

        $symbols = implode(PHP_EOL, $symbols);

        return <<<SVG
        <svg style="height: 0">
            <defs>
                $symbols
            </defs>
        </svg>
        SVG;
    }

    private static function normalizeSymbolId(string $file): string
    {
        return ltrim(
            str_replace(
                [DIRECTORY_SEPARATOR, '.'],
                '-',
                sprintf(
                    '%s-%s',
                    pathinfo($file, PATHINFO_DIRNAME),
                    pathinfo($file, PATHINFO_FILENAME)
                )
            ),
            '-'
        );
    }

    public function getSymbol(string $file): string
    {
        $id = self::normalizeSymbolId($file);

        if (!array_key_exists($id, $this->symbols)) {
            $assetRoot = realpath(
                dirname(__DIR__, 2) . '/assets'
            ) . DIRECTORY_SEPARATOR;
            $asset = realpath($assetRoot . $file);

            if ($asset === false) {
                throw new RuntimeException(
                    sprintf('Could not locate file: "%s%s"', $assetRoot, $file)
                );
            }

            if (!str_starts_with($asset, $assetRoot)) {
                throw new RuntimeException(
                    sprintf(
                        'Asset "%s" tried to escape asset root "%s".',
                        $asset,
                        $assetRoot
                    )
                );
            }

            $this->symbols[$id] = file_get_contents($asset);
        }

        return sprintf('<use href="#%s" />', $id);
    }
}
