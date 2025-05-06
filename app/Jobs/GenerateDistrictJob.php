<?php

namespace App\Jobs;

use App\Models\IndonesiaCity;
use App\Models\IndonesiaDistrict;
use App\Services\IdnLocationService;
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
        $idnLocationService = app(IdnLocationService::class);
        $cities = IndonesiaCity::get();

        foreach ($cities as $city) {
            $districts = $idnLocationService->fetchAndFilterData('kecamatan', $city->code);

            foreach ($districts as $district) {
                $indonesiaDistrict = IndonesiaDistrict::filterByCode($district['kode'])
                    ->firstOrNew();
                $indonesiaDistrict->code = $district['kode'];
                $indonesiaDistrict->name = $district['nama'];
                $indonesiaDistrict->city_code = $city->code;
                $indonesiaDistrict->save();
            }
        }
    }
}
