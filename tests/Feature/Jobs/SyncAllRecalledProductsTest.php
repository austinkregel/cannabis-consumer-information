<?php

namespace Tests\Feature\Jobs;

use App\Jobs\FetchRecalledProductsJob;
use App\Jobs\SyncAllRecalledProducts;
use App\Models\Recall;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class SyncAllRecalledProductsTest extends TestCase
{
    use RefreshDatabase;

    public function testHandle()
    {
        $job = new SyncAllRecalledProducts();

        $dispatcher = Mockery::mock(Dispatcher::class);

        $recalls = Recall::factory()->count(101)->create();

        $dispatcher->shouldReceive('dispatch')
            ->times(101)
            ->with(Mockery::on(fn (FetchRecalledProductsJob $job) => $recalls->pluck('id')->contains($job->recall->id)));

        $job->handle($dispatcher);
    }
}