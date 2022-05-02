<?php
declare(strict_types=1);

namespace Tests\Unit\Services\Pdf;

use App\Services\Pdf\PdfParserService;
use Mockery\MockInterface;
use Smalot\PdfParser\Document;
use Smalot\PdfParser\Parser;
use Tests\TestCase;

class PdfParserServiceTest extends TestCase
{
    protected MockInterface $pdfParser;

    protected PdfParserService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->pdfParser = \Mockery::mock(Parser::class);
        $this->service = new PdfParserService($this->pdfParser);
    }

    public function testGetPdfTextFromFile()
    {
        $filename = 'pdf.pdf';
        $expectedReturnText = 'test text';

        $mockPdfFile = \Mockery::mock(Document::class);
        $mockPdfFile->shouldReceive('getText')->once()->andReturn($expectedReturnText);

        $this->pdfParser->shouldReceive('parseFile')->once()->with($filename)->andReturn($mockPdfFile);

        $result = $this->service->getPdfTextFromFile($filename);
        $this->assertSame($expectedReturnText, $result);
    }

    public function testGetPdfTextFromRawContent()
    {
        $content = 'test raw content';
        $expectedReturnText = 'test text';

        $mockPdfFile = \Mockery::mock(Document::class);
        $mockPdfFile->shouldReceive('getText')->once()->andReturn($expectedReturnText);

        $this->pdfParser->shouldReceive('parseContent')->once()->with($content)->andReturn($mockPdfFile);

        $result = $this->service->getPdfTextFromRawContent($content);
        $this->assertSame($expectedReturnText, $result);
    }
}
