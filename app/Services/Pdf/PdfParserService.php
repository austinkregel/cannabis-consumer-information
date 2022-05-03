<?php
declare(strict_types=1);

namespace App\Services\Pdf;

use App\Contracts\Services\Pdf\PdfParserServiceContract;
use Smalot\PdfParser\Document;

class PdfParserService implements PdfParserServiceContract
{
    protected PdfReaderService $parser;

    public function __construct(PdfReaderService $parser)
    {
        $this->parser = $parser;
    }

    public function getPdfTextFromFile(string $filename): string
    {
        $pdf = $this->parser->parseFile($filename);
        return $this->readPdfText($pdf);
    }

    public function getPdfTextFromRawContent(string $contents): string
    {
        $pdf = $this->parser->parseContent($contents);
        return $this->readPdfText($pdf);
    }

    protected function readPdfText(Document $pdf): string
    {
        return $pdf->getText();
    }
}
