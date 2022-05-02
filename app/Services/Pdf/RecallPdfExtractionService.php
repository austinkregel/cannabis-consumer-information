<?php
declare(strict_types=1);

namespace App\Services\Pdf;

use App\Contracts\Services\Pdf\PdfParserServiceContract;
use App\Contracts\Services\Pdf\RecallPdfExtractionServiceContract;

class RecallPdfExtractionService implements RecallPdfExtractionServiceContract
{
    protected PdfParserServiceContract $parserService;

    public function __construct(PdfParserServiceContract $parserService)
    {
        $this->parserService = $parserService;
    }

    public function getRecallsFromPdfFile(string $filename): array
    {
        $pdfText = $this->parserService->getPdfTextFromFile($filename);
        $lines = explode("\n", $pdfText);

        return $this->parsePdf($lines);
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

            $recalls[$currentStore][$currentPackage] .= ' ' . str_replace(array_keys($recalls), '', trim($line, "\t\r\n "));
        }

        /**
         * Depending on how a package recall block is structured there may be another store name trailing at the end
         * of the recall info. Here we will just filter out store names from the recall info based on the store names
         * that are in our recalls array.
         */
        $stores = array_keys($recalls);
        foreach ($recalls as $store => $packages) {
            foreach ($packages as $package => $recallInfo) {
                $recalls[$store][$package] = trim(str_replace($stores, '', $recallInfo), "\t\r\n ");
            }
        }
        return $recalls;
    }

    protected function isStoreBlock(string $line): ?string
    {
        $storeNameRegex = '/This recall affects.*from ([a-zA-Z0-9\-_ &]*).*/i';
        preg_match_all($storeNameRegex, $line, $matches);
        if (!empty($matches[1])) {
            return trim($matches[1][0], "\t\r\n ");
        }

        return null;
    }

    protected function isPackageBlock(string $line): ?string
    {
        $packageRegex = '/[Package]? ?#? ?(1A[A-Z0-9]*)/i';
        preg_match_all($packageRegex, $line, $matches);
        if (!empty($matches[1])) {
            return trim($matches[1][0], "\t\r\n ");
        }

        return null;
    }
}
