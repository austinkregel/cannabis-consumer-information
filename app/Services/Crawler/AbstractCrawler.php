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
        $response = $this->client->get($url, [
            'headers' => [
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:123.0) Gecko/20100101 Firefox/123.0',
            ]
        ]);
        $contents = $response->getBody()->getContents();
        preg_match_all('/<a href="(.*?)">(.*?)<\/a>/', $contents, $matches);

        $links = $matches[1];
        $titles = $matches[2];

        return array_combine($titles, $links);
    }
}
