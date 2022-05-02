<?php
declare(strict_types=1);

namespace App\Services\Pdf;

use App\Contracts\Services\Pdf\PdfParserServiceContract;
use Smalot\PdfParser\Document;
use Smalot\PdfParser\Parser;

class PdfParserService implements PdfParserServiceContract
{
    protected Parser $parser;

    public function __construct(Parser $parser)
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
