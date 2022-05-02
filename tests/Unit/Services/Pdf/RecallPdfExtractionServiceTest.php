<?php
declare(strict_types=1);

namespace Tests\Unit\Services\Pdf;

use App\Contracts\Services\Pdf\PdfParserServiceContract;
use App\Services\Pdf\RecallPdfExtractionService;
use Mockery\MockInterface;
use Tests\TestCase;

class RecallPdfExtractionServiceTest extends TestCase
{
    protected MockInterface $pdfParserService;

    protected RecallPdfExtractionService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->pdfParserService = \Mockery::mock(PdfParserServiceContract::class);
        $this->service = new RecallPdfExtractionService($this->pdfParserService);
    }

    public function testGetPackageIdsFromPdfFile()
    {
        $filename = 'pdf.pdf';
        $pdfContent = "Pdf header \nSome more unrelated content\nPackage # 1A12345\n\tPackage#1A54321\n Package #1A98765\t\nPackage 1A87646";

        $this->pdfParserService->shouldReceive('getPdfTextFromFile')->once()->with($filename)->andReturn($pdfContent);

        $result = $this->service->getPackageIdsFromPdfFile($filename);
        $this->assertEquals([
            '1A12345',
            '1A54321',
            '1A98765',
            '1A87646',
        ], $result);
    }
}
