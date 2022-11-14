<?php

namespace App\Listeners;

use App\Events\DispensaryHasBeenInvolvedInRecall;
use App\Events\ProductHasBeenInvolvedInRecall;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogActivityListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param $event
     * @return void
     */
    public function handle(ProductHasBeenInvolvedInRecall | DispensaryHasBeenInvolvedInRecall $event)
    {
        if ($event instanceof ProductHasBeenInvolvedInRecall) {
            $product = $event->product;
            $recall = $event->recall;
            
            activity()
                ->causedBy($recall)
                ->performedOn($product)
                ->createdAt($recall->published_at)
                ->log('recall issued');
        } else {
            $dispensary = $event->dispensary;
            $recall = $event->recall;
            
            activity()
                ->causedBy($recall)
                ->performedOn($dispensary)
                ->createdAt($recall->published_at)
                ->log('recall issued');
        }
;
    }
}
