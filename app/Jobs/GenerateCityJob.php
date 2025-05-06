<?php

namespace App\Jobs;

use App\Models\IndonesiaCity;
use App\Models\IndonesiaProvince;
use App\Services\IdnLocationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateCityJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $idnLocationService = app(IdnLocationService::class);
        $provinces = IndonesiaProvince::get();

        foreach ($provinces as $province) {
            $cities = $idnLocationService->fetchAndFilterData('kabupaten', $province->code);

            foreach ($cities as $city) {
                $indonesiaCity = IndonesiaCity::filterByCode($city['kode'])
                    ->firstOrNew();
                $indonesiaCity->code = $city['kode'];
                $indonesiaCity->name = str_replace('KAB.', 'KABUPATEN', $city['nama']);
                $indonesiaCity->province_code = $province->code;
                $indonesiaCity->save();
            }
        }
    }
}
