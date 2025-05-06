<?php

namespace App\Jobs;

use App\Models\IndonesiaCity;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateDistrictJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $cities = IndonesiaCity::pluck('code'); // ambil hanya code

        foreach ($cities as $cityCode) {
            GenerateDistrictByCityJob::dispatch($cityCode);
        }
    }
}
