<?php
declare(strict_types=1);

namespace App\Pdf;

use Dompdf\Dompdf;
use Dompdf\Options;

final readonly class DomPdfFactory implements PdfFactoryInterface
{
    public function __construct(private Options $options = new Options())
    {
    }

    public function createFromHtml(string $html): PdfInterface
    {
        $pdf = new DomPdf($this->options);
        $pdf->loadHtml($html);
        $pdf->render();

        return new DomPdfProxy(buffer: $pdf, isRendered: true);
    }
}