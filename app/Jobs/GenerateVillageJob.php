<?php

namespace App\Jobs;

use App\Models\IndonesiaDistrict;
use App\Models\IndonesiaVillage;
use App\Services\IdnLocationService;
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
        $idnLocationService = app(IdnLocationService::class);
        $districts = IndonesiaDistrict::get();

        foreach ($districts as $district) {
            $villages = $idnLocationService->fetchAndFilterData('desa', $district->code);

            foreach ($villages as $village) {
                $indonesiaVillage = IndonesiaVillage::filterByCode($village['kode'])
                    ->firstOrNew();
                $indonesiaVillage->code = $village['kode'];
                $indonesiaVillage->name = $village['nama'];
                $indonesiaVillage->district_code = $district->code;
                $indonesiaVillage->save();
            }
        }
    }
}
