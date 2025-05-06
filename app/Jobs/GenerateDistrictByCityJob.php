<?php

namespace App\Jobs;

use App\Models\IndonesiaDistrict;
use App\Services\IdnLocationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Throwable;

class GenerateDistrictByCityJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $cityCode;

    public function __construct(string $cityCode)
    {
        $this->cityCode = $cityCode;
    }

    public function handle(): void
    {
        try {
            $idnLocationService = app(IdnLocationService::class);
            $districts = $idnLocationService->fetchAndFilterData('kecamatan', $this->cityCode);

            foreach ($districts as $district) {
                $indonesiaDistrict = IndonesiaDistrict::filterByCode($district['kode'])->firstOrNew();
                $indonesiaDistrict->code = $district['kode'];
                $indonesiaDistrict->name = $district['nama'];
                $indonesiaDistrict->city_code = $this->cityCode;
                $indonesiaDistrict->save();
            }
        } catch (Throwable $e) {
            Log::error("Failed to process city $this->cityCode: {$e->getMessage()}");
        }
    }
}
