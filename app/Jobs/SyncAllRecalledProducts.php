<?php

namespace App\Jobs;

use App\Models\Recall;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncAllRecalledProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle(Dispatcher $dispatcher)
    {
        $page = 1;

        do {
            $paginator = Recall::paginate(100, ['*'], 'page', $page++);

            foreach ($paginator->items() as $recall) {
                $dispatcher->dispatch(new FetchRecalledProductsJob($recall));
            }
        } while ($paginator->hasMorePages());
    }
}
