<?php

namespace App\Services\Crawler;

use App\Contracts\Services\Crawler\CrawlerContract;
use Exception;
use GuzzleHttp\Client;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

class AbstractCrawler implements CrawlerContract
{
    public function __construct(public Client $client)
    {
    }

    public function crawl(string $url): array
    {
        $response = $this->client->get($url);
        $contents = $response->getBody()->getContents();
        preg_match_all('/<a href="(.*?)">(.*?)<\/a>/', $contents, $matches);

        $links = $matches[1];
        $titles = $matches[2];

        return array_combine($titles, $links);
    }
}