<?php
declare(strict_types=1);

namespace App\Pdf;

use Dompdf\Dompdf;

class DomPdfProxy implements PdfInterface
{
    private ?string $pdf = null;

    public function __construct(private readonly Dompdf $buffer, private bool $isRendered = false)
    {
    }

    public function __toString(): string
    {
        if (!$this->isRendered) {
            $this->buffer->render();
            $this->isRendered = true;
        }

        return $this->pdf ??= $this->buffer->output();
    }
}