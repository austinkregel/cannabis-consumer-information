<?php

namespace App\Jobs;

use App\Contracts\Services\Pdf\RecallPdfExtractionServiceContract;
use App\Models\Product;
use App\Models\Recall;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchRecalledProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Recall $recall)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(RecallPdfExtractionServiceContract $pdfExtractionService)
    {
        try {
            file_put_contents($path = storage_path('/' . $this->recall->id . '.pdf'), file_get_contents($this->recall->mra_public_notice_url));

            $data = $pdfExtractionService->getPackageIdsFromPdfFile($path);
        } catch (\Exception $e) {
            if ($e->getMessage() === 'Secured pdf file are currently not supported.') {
                info('Secured pdf files are currently not supported.', [
                    'exception' => $e->getMessage(),
                    'recall' => $this->recall->toArray(),
                ]);
            }

            info('Failed to fetch recalled products for ' . $this->recall->mra_public_notice_url);
            return;
        } finally {
            unlink($path);
        }

        foreach ($data as $product) {
            $product = Product::firstOrCreate([
                'id' => $product,
            ]);

            if ($product->wasRecentlyCreated) {
                $product->recalls()->attach($this->recall->id);
            }
        }

    }
}