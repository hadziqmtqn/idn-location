<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\IndonesiaCity;
use App\Models\IndonesiaDistrict;
use App\Models\IndonesiaProvince;
use App\Models\IndonesiaVillage;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function selectProvince(Request $request)
    {
        $search = $request->input('q');

        $provinces = IndonesiaProvince::query()
            ->when($search, function($query) use($search){
                $query->where('name', 'LIKE', '%'.$search.'%');
            })
            ->select([
                'code',
                'name'
            ])
            ->get();

        return response()->json($provinces);
    }

    public function selectCity(Request $request)
    {
        $search = $request->input('q');
        $province = $request->input('province');

        $cities = IndonesiaCity::query()
            ->join('indonesia_provinces', 'indonesia_cities.province_code', '=', 'indonesia_provinces.code')
            ->when($search, function($query) use($search){
                $query->where('indonesia_cities.name', 'LIKE', '%'.$search.'%');
            })
            ->where('indonesia_provinces.name', $province)
            ->select([
                'indonesia_cities.code',
                'indonesia_cities.name',
                'indonesia_provinces.name as province_name'
            ])
            ->get();

        return response()->json($cities);
    }

    public function selectDistrict(Request $request)
    {
        $search = $request->input('q');
        $city = $request->input('city');

        $districts = IndonesiaDistrict::query()
            ->join('indonesia_cities', 'indonesia_districts.city_code', '=', 'indonesia_cities.code')
            ->when($search, function($query) use($search){
                $query->where('indonesia_districts.name', 'LIKE', '%'.$search.'%');
            })
            ->where('indonesia_cities.name', $city)
            ->select([
                'indonesia_districts.code',
                'indonesia_districts.name',
                'indonesia_cities.name as city_name'
            ])
            ->get();

        return response()->json($districts);
    }

    public function selectVillage(Request $request)
    {
        $search = $request->input('q');
        $district = $request->input('district');

        $villages = IndonesiaVillage::query()
            ->join('indonesia_districts', 'indonesia_villages.district_code', '=', 'indonesia_districts.code')
            ->when($search, function($query) use($search){
                $query->where('indonesia_villages.name', 'LIKE', '%'.$search.'%');
            })
            ->where('indonesia_districts.name', $district)
            ->select([
                'indonesia_villages.code',
                'indonesia_villages.name',
                'indonesia_districts.name as district_name'
            ])
            ->get();

        return response()->json($villages);
    }
}
