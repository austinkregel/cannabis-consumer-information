<?php
declare(strict_types=1);

namespace App\Services\Pdf;

use App\Contracts\Services\Pdf\PdfParserServiceContract;
use App\Contracts\Services\Pdf\RecallPdfExtractionServiceContract;
use mikehaertl\pdftk\Pdf;

class RecallPdfExtractionService implements RecallPdfExtractionServiceContract
{
    protected PdfParserServiceContract $parserService;

    public function __construct(PdfParserServiceContract $parserService)
    {
        $this->parserService = $parserService;
    }

    public function getRecallsFromPdfFile(string $filename): array
    {
        try {
            $pdfText = $this->parserService->getPdfTextFromFile($filename);
            $lines = explode("\n", $pdfText);

            return $this->parsePdf($lines);
        } catch (\Exception $e) {
            if ($e->getMessage() === 'Secured pdf file are currently not supported.') {
                // We can actually use pdftk to decrypt the file and then re-run the extraction.
                $pdf = new Pdf();
                $pdf->addFile($filename, null, '')->saveAs($filename);
                return $this->getRecallsFromPdfFile($filename);
            }
            throw $e;
        }
    }

    public function getPackageIdsFromPdfFile(string $filename): array
    {
        try {
            $pdfText = $this->parserService->getPdfTextFromFile($filename);
            $lines = explode("\n", $pdfText);

            return $this->parsePackagesFromPdf($lines);
        } catch (\Exception $e) {
            if ($e->getMessage() === 'Secured pdf file are currently not supported.') {
                // We can actually use pdftk to decrypt the file and then re-run the extraction.
                $pdf = new Pdf();
                $pdf->addFile($filename, null, '')->saveAs($filename);
                // Sometimes decrypting results in some missing data so we filter out things that obvs arent ids.
                return array_values(array_filter($this->getPackageIdsFromPdfFile($filename), fn ($product) => strlen($product) > 2));
            }
            throw $e;
        }
    }

    protected function parsePackagesFromPdf(array $lines): array
    {
        $packages = [];
        foreach ($lines as $line) {
            if ($package = $this->isPackageBlock($line)) {
                $packages[] = $package;
            }
        }

        return $packages;
    }

    protected function parsePdf(array $lines): array
    {
        $recalls = [];

        $currentStore = null;
        $currentPackage = null;

        foreach ($lines as $line) {
            $isStoreBlock = $this->isStoreBlock($line);
            $isPackageBlock = $this->isPackageBlock($line);

            if (!empty($isStoreBlock)) {
                // New store has been discovered, set package info and reset
                $currentStore = $isStoreBlock;
                $currentPackage = null;
                continue;
            }

            if (!empty($isPackageBlock)) {
                // New package discovered
                $currentPackage = $isPackageBlock;
                continue;
            }

            if (empty($currentPackage)) continue;

            if (empty($recalls[$currentStore])) {
                $recalls[$currentStore] = [];
            }

            if (empty($recalls[$currentStore][$currentPackage])) {
                $recalls[$currentStore][$currentPackage] = '';
            }

            $recalls[$currentStore][$currentPackage] .= ' ' . str_replace(array_keys($recalls), '', $this->trim($line));
        }

        /**
         * Depending on how a package recall block is structured there may be another store name trailing at the end
         * of the recall info. Here we will just filter out store names from the recall info based on the store names
         * that are in our recalls array.
         */
        $stores = array_keys($recalls);
        foreach ($recalls as $store => $packages) {
            foreach ($packages as $package => $recallInfo) {
                $recalls[$store][$package] = $this->trim(str_replace($stores, '', $recallInfo));
            }
        }
        return $recalls;
    }

    protected function isStoreBlock(string $line): ?string
    {
        $storeNameRegex = '/This recall affects.*from ([a-zA-Z0-9\-_ &]*).*/i';
        preg_match_all($storeNameRegex, $line, $matches);
        if (!empty($matches[1])) {
            return $this->trim($matches[1][0]);
        }

        return null;
    }

    protected function isPackageBlock(string $line): ?string
    {
        $packageRegex = '/[Package]? ?#? ?(1A[A-Z0-9]*)/i';
        preg_match_all($packageRegex, $line, $matches);
        if (!empty($matches[1])) {
            return $this->trim($matches[1][0]);
        }

        return null;
    }

    protected function trim(string $value): string
    {
        return trim($value, "\t\r\n ");
    }
}
