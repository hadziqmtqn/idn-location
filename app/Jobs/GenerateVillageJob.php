<?php

namespace App\Jobs;

use App\Models\IndonesiaVillage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateVillageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected mixed $districtCode;
    protected mixed $code;
    protected mixed $name;

    /**
     * @param mixed $districtCode
     * @param mixed $code
     * @param mixed $name
     */
    public function __construct(mixed $districtCode, mixed $code, mixed $name)
    {
        $this->districtCode = $districtCode;
        $this->code = $code;
        $this->name = $name;
    }

    public function handle(): void
    {
        $indonesiaVillage = IndonesiaVillage::filterByCode($this->code)
            ->firstOrNew();
        $indonesiaVillage->code = $this->code;
        $indonesiaVillage->name = $this->name;
        $indonesiaVillage->district_code = $this->districtCode;
        $indonesiaVillage->save();
    }
}
