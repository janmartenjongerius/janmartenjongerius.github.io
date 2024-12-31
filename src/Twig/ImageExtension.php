<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Image;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class ImageExtension extends AbstractExtension
{
    private const DEFAULT_WIDTH = 50;
    private const DEFAULT_HEIGHT = 50;

    public function getFilters(): iterable
    {
        yield new TwigFilter(
            'image',
            $this->convertImage(...),
            ['is_safe' => ['html']]
        );
    }

    public function convertImage(
        Image $image,
        string $alt = '',
        int|string $width = self::DEFAULT_WIDTH,
        int|string $height = self::DEFAULT_HEIGHT
    ): string {
        $fh = $image->getContent();
        rewind($fh);
        $contentType = mime_content_type($fh);
        $content = base64_encode(stream_get_contents($fh));
        $alt = strip_tags($alt);

        if (is_string($width)) {
            $width = strip_tags($width);
        }

        if (is_string($height)) {
            $height = strip_tags($height);
        }

        return <<<IMAGE
            <img
                alt="$alt" 
                width="$width" 
                height="$height"
                src="data:$contentType;base64,$content" />
        IMAGE;
    }
}
