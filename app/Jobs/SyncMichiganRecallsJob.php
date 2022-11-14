<?php

namespace App\Jobs;

use App\Contracts\Repositories\SystemUserRepositoryContract;
use App\Contracts\Services\Crawler\CrawlerContract;
use App\Models\Recall;
use App\Services\Crawler\PdfCrawler;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncMichiganRecallsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public const MICHIGAN_RECALLS_URL = 'https://www.michigan.gov/cra/bulletins';

    public function handle(CrawlerContract $crawler, SystemUserRepositoryContract $systemUserRepository)
    {
        $systemUser = $systemUserRepository->findOrFail();
        auth()->login($systemUser);

        $pdfsOnSite = $crawler->crawl(static::MICHIGAN_RECALLS_URL);
    
        $recalls = array_filter($pdfsOnSite, function($pdf) {
            return stripos($pdf['title'], 'recall') !== false;
        });

        info('Found ' . count($recalls) . ' recall pdfs on Michigan state site.');
        foreach ($recalls as $link) {
            $recall = Recall::firstWhere('original_name', $link['original_title']);
            if (empty($recall)) {
                info('Creating new recall for '. $link['original_title']);
                Recall::create([
                    'mra_public_notice_url' => $link['link'],
                    'published_at' => $link['published_at'],
                    'user_id' => $systemUser->id,
                    'name' => $link['title'],
                    'original_name' => $link['original_title'],
                ]);
                continue;
            }
            info('Updating the CRA link');
            $recall->update([
                'mra_public_notice_url' => $link['link'],
            ]);
        }

        auth()->logout();
    }
}
