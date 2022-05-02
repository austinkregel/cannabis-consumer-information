<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('test', function () {
    $url = 'https://www.michigan.gov/mra/-/media/Project/Websites/mra/bulletin/1Public-Health-an-Safety-Advisory/3843_Euclid_Recall_Notice_7-7-2021_FINAL_729720_7.pdf';

    file_put_contents('/tmp/test.pdf', file_get_contents($url));
    
    $pdf = new \Spatie\PdfToImage\Pdf('/tmp/test.pdf');
    $pdf->saveImage('output.jpg');
});