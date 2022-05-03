<?php

namespace App\Contracts\Services\Crawler;

interface CrawlerContract
{
    public function crawl(string $url): array;
}