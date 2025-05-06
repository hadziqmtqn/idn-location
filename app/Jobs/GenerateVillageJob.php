<?php

namespace App\Jobs;

use App\Models\IndonesiaDistrict;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateVillageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $districts = IndonesiaDistrict::pluck('code');

        foreach ($districts as $district) {
            GenerateVillageByDistrictJob::dispatch($district);
        }
    }
}
