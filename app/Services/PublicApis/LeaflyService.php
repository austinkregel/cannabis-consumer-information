<?php

namespace App\Services\PublicApis;

use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;

class LeaflyService 
{

    public function __construct(public Client $client)
    {
        
    }

    public function getStrainByName(string $name)
    {
    }

    public function findAll(int $limit = 20, int $page = 1)
    {
        return $this->thing($limit, $page);
    }

    protected function thing(int $limit = 20, int $page = 1)
    {
        $skip = ($page - 1) * $limit;
        $take = $limit;

        $response = $this->client->get(
            sprintf('https://consumer-api.leafly.com/api/strains/v1/?take=%s&skip=%s', max(min($take, 60), 1), $skip)
        );

        $contents = json_decode($response->getBody()->getContents());

        return new LengthAwarePaginator(
            $contents->data, 
            $contents->metadata->totalCount, 
            $limit, 
            $page
        );
    }
}