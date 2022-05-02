<?php
declare(strict_types=1);

namespace App\Contracts\Services\Pdf;

interface RecallPdfExtractionServiceContract
{
    public function getRecallsFromPdfFile(string $filename): array;
}
