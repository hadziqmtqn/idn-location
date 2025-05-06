<?php

namespace App\Jobs;

use App\Models\IndonesiaDistrict;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateDistrictJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected mixed $cityCode;
    protected mixed $code;
    protected mixed $name;

    /**
     * @param mixed $cityCode
     * @param mixed $code
     * @param mixed $name
     */
    public function __construct(mixed $cityCode, mixed $code, mixed $name)
    {
        $this->cityCode = $cityCode;
        $this->code = $code;
        $this->name = $name;
    }

    public function handle(): void
    {
        $indonesiaCity = IndonesiaDistrict::filterByCode($this->code)
            ->firstOrNew();
        $indonesiaCity->code = $this->code;
        $indonesiaCity->name = $this->name;
        $indonesiaCity->city_code = $this->cityCode;
        $indonesiaCity->save();
    }
}
