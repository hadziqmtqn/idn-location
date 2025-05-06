<?php

namespace App\Jobs;

use App\Models\IndonesiaCity;
use App\Models\IndonesiaProvince;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateCityJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected IndonesiaProvince $indonesiaProvince;
    protected mixed $code;
    protected mixed $name;

    public function __construct(IndonesiaProvince $indonesiaProvince, mixed $code, mixed $name)
    {
        $this->indonesiaProvince = $indonesiaProvince;
        $this->code = $code;
        $this->name = $name;
    }

    public function handle(): void
    {
        $indonesiaCity = IndonesiaCity::filterByCode($this->code)
            ->firstOrNew();
        $indonesiaCity->code = $this->code;
        $indonesiaCity->name = str_replace('KAB.', 'KABUPATEN', $this->name);
        $indonesiaCity->province_code = $this->indonesiaProvince->code;
        $indonesiaCity->save();
    }
}
