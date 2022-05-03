<?php

namespace App\Services\Crawler;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;

class PdfCrawler extends AbstractCrawler 
{
    public function __construct(public Client $client)
    {
    }

    public function crawl(string $url): array
    {
        $links = parent::crawl($url);

        $data = [];
        foreach ($links as $title => $link) {
            if (stripos($link, '.pdf') === false) {
                continue;
            }

            $originalTitle = $title;
            $link = explode('" ', $link)[0];

            // All titles seem to have a date at the start in either M-d-y or M-y format, followed by the page title.
            [$date, $title] = explode(' -', $title);
            
            $date = str_replace('-','-', trim($date));

            $parts = array_map('trim', explode('-', $title));
            
            // For some reason they're using hyphens to denote parts of the title, likley different categories.
            $title = str_replace('&nbsp;', '', count($parts) > 1 ? end($parts) : $parts[0]);
            $category = count($parts) > 1 ? $parts[0] : null;
            try {
                // Do a little jig for inconsistent date formats. Woo!
                $date = Carbon::createFromFormat('m-d-Y', $date);
            } catch (Exception $e) {
                try { 
                    $date = Carbon::createFromFormat('m-Y', $date);
                } catch (Exception $e) {
                    dd($e, $date);
                }
            }
        
            $data[] = [
                'title' => $title,
                'link' => 'https://michigan.gov'.$link,
                'published_at' => $date,
                'parts' => $parts,
                'original_title' => $originalTitle,
                'category' => $category,
            ];
        }
        return $data;
    }
}
