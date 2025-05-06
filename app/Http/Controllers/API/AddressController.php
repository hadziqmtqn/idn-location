<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CityRequest;
use App\Http\Requests\V1\DistrictRequest;
use App\Http\Requests\V1\ProvinceRequest;
use App\Http\Requests\V1\VillageRequest;
use App\Models\IndonesiaCity;
use App\Models\IndonesiaDistrict;
use App\Models\IndonesiaProvince;
use App\Models\IndonesiaVillage;
use Illuminate\Http\JsonResponse;

class AddressController extends Controller
{
    public function selectProvince(ProvinceRequest $request): JsonResponse
    {
        $provinces = IndonesiaProvince::query()
            ->search($request)
            ->get();

        return response()->json($provinces->map(function (IndonesiaProvince $indonesiaProvince) {
            return collect([
                'code' => $indonesiaProvince->code,
                'name' => $indonesiaProvince->name
            ]);
        }));
    }

    public function selectCity(CityRequest $request): JsonResponse
    {
        $cities = IndonesiaCity::with('provinceCode:id,name')
            ->search($request)
            ->get();

        return response()->json($cities->map(function (IndonesiaCity $indonesiaCity) {
            return collect([
                'code' => $indonesiaCity->code,
                'name' => $indonesiaCity->name,
                'province_name' => $indonesiaCity->provinceCode?->name
            ]);
        }));
    }

    public function selectDistrict(DistrictRequest $request): JsonResponse
    {
        $districts = IndonesiaDistrict::with('cityCode:id,name')
            ->search($request)
            ->get();

        return response()->json($districts->map(function (IndonesiaDistrict $indonesiaDistrict) {
            return collect([
                'code' => $indonesiaDistrict->code,
                'name' => $indonesiaDistrict->name,
                'city_name' => $indonesiaDistrict->cityCode?->name
            ]);
        }));
    }

    public function selectVillage(VillageRequest $request): JsonResponse
    {
        $villages = IndonesiaVillage::with('districtCode:id,name')
            ->search($request)
            ->get();

        return response()->json($villages->map(function (IndonesiaVillage $indonesiaVillage) {
            return collect([
                'code' => $indonesiaVillage->code,
                'name' => $indonesiaVillage->name,
                'district_name' => $indonesiaVillage->districtCode?->name
            ]);
        }));
    }
}
