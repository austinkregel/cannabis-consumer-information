<?php

namespace App\Jobs;

use App\Contracts\Repositories\SystemUserRepositoryContract;
use App\Contracts\Services\Pdf\RecallPdfExtractionServiceContract;
use App\Events\DispensaryHasBeenInvolvedInRecall;
use App\Events\ProductHasBeenInvolvedInRecall;
use App\Models\Dispensary;
use App\Models\Product;
use App\Models\Recall;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use mikehaertl\pdftk\Pdf;

class FetchRecalledProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Recall $recall)
    {
    }

    public function handle(RecallPdfExtractionServiceContract $pdfExtractionService, SystemUserRepositoryContract $systemUserRepository)
    {
        $systemUser = $systemUserRepository->findOrFail();
        auth()->login($systemUser);
        file_put_contents($path = storage_path('/' . $this->recall->id . '.pdf'), file_get_contents($this->recall->mra_public_notice_url));
        try {
            $data = $pdfExtractionService->getAllIdentifiers($path);
        } catch (\Exception $e) {
            info('Failed to fetch recalled products for ' . $this->recall->mra_public_notice_url, [
                'exception' => $e->getMessage(),
            ]);
            return;
        } finally {
            unlink($path);
        }

        $data = collect($data)->groupBy(fn ($str) => str_starts_with($str, '1A') ? 'product_id' : 'license_number');

        $products = $data->get('product_id', []);
        $licenseNumbers = $data->get('license_number', []);

        foreach ($products as $product) {
            $product = Product::firstOrCreate([
                'product_id' => $product,
            ]);

            if ($product->recalls()->where('id', $this->recall->id)->doesntExist()) {
                $product->recalls()->attach($this->recall->id);
                event(new ProductHasBeenInvolvedInRecall($product, $this->recall));
            }
        }

        foreach ($licenseNumbers as $licenseNumber) {
            $license = Dispensary::where('license_number', $licenseNumber)->first();
            
            if (empty($license)) {
                $license = Dispensary::create([
                    'license_number' => $licenseNumber,
                    'name' => 'Likely a closed establishment'
                ]);
            }

            if ($license->recalls()->where('id', $this->recall->id)->doesntExist()) {
                $license->recalls()->attach($this->recall->id);
                event(new DispensaryHasBeenInvolvedInRecall($license, $this->recall));
            }
        }
        auth()->logout();
    }
}
