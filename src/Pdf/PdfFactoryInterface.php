<?php
declare(strict_types=1);

namespace App\Pdf;

interface PdfFactoryInterface
{
    public function createFromHtml(string $html): PdfInterface;
}