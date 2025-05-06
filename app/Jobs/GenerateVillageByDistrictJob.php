<?php

namespace App\Jobs;

use App\Models\IndonesiaVillage;
use App\Services\IdnLocationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class GenerateVillageByDistrictJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $districtCode;

    public function __construct(string $districtCode)
    {
        $this->districtCode = $districtCode;
    }

    public function handle(): void
    {
        try {
            $idnLocationService = app(IdnLocationService::class);

            $villages = $idnLocationService->fetchAndFilterData('desa', $this->districtCode);

            foreach ($villages as $village) {
                $indonesiaVillage = IndonesiaVillage::filterByCode($village['kode'])
                    ->firstOrNew();
                $indonesiaVillage->code = $village['kode'];
                $indonesiaVillage->name = $village['nama'];
                $indonesiaVillage->district_code = $this->districtCode;
                $indonesiaVillage->save();
            }
        } catch (Throwable $throwable) {
            Log::error("Failed to process district $this->districtCode: {$throwable->getMessage()}");
        }
    }
}
