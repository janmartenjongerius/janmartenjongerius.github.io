<?php

declare(strict_types=1);

namespace App\Twig;

use RuntimeException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class SvgExtension extends AbstractExtension
{
    use HtmlAttributesTrait;

    private const DEFAULT_SVG_ATTRIBUTES = [
        'xmlns' => 'http://www.w3.org/2000/svg',
        'aria-hidden' => 'true'
    ];

    private array $symbols = [];

    public function getFunctions(): iterable
    {
        yield new TwigFunction(
            'svg',
            $this->getSvg(...),
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
        <svg height="0">
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

    private function getSymbol(string $file): string
    {
        $id = self::normalizeSymbolId($file);

        if (!array_key_exists($id, $this->symbols)) {
            $assetRoot = realpath(
                dirname(__DIR__, 2) . '/assets'
            ) . DIRECTORY_SEPARATOR;
            $asset = realpath($assetRoot . $file);

            if ($asset === false) {
                throw new RuntimeException(
                    sprintf(
                        'Could not locate file: "%s%s"',
                        $assetRoot,
                        $file
                    )
                );
            }

            $this->symbols[$id] = file_get_contents($asset);
        }

        return sprintf('<use href="#%s" />', $id);
    }

    public function getSvg(
        string $file,
        string $class = null,
        int|string $width = null,
        int|string $height = null,
        ?string $fill = null
    ): string {
        $symbol = $this->getSymbol($file);
        $attributes = self::getHtmlAttributes(
            array_replace(
                self::DEFAULT_SVG_ATTRIBUTES,
                [
                    'class' => $class,
                    'width' => $width,
                    'height' => $height,
                    'fill' => $fill
                ]
            )
        );

        return <<<SVG
        <svg $attributes>
            $symbol
        </svg>
        SVG;
    }
}
