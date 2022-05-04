<?php

namespace App\Jobs;

use App\Models\Recall;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncAllRecalledProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $page = 1;

        do {
            $paginator = Recall::paginate(100, ['*'], 'page', $page++);

            foreach ($paginator->items() as $recall) {
                dispatch(new FetchRecalledProductsJob($recall));
            };
        } while ($paginator->hasMorePages());
    }
}
