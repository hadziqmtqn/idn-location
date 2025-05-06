<?php

namespace App\Services\GenerateData;

use App\Models\IndonesiaProvince;

class GenerateProvinceService
{
    protected IndonesiaProvince $indonesiaProvince;

    public function __construct(IndonesiaProvince $indonesiaProvince)
    {
        $this->indonesiaProvince = $indonesiaProvince;
    }

    public function saveData(array $data): void
    {
        foreach ($data as $item) {
            $indonesiaProvince = IndonesiaProvince::filterByCode($item['kode'])
                ->firstOrNew();
            $indonesiaProvince->code = $item['kode'];
            $indonesiaProvince->name = $item['nama'];
            $indonesiaProvince->save();
        }
    }
}
