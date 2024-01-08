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

        $provinces = array();
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
        $province_code = $request->input('province_code');

        $cities = array();
        $cities = IndonesiaCity::query()
            ->join('indonesia_provinces', 'indonesia_cities.province_code', '=', 'indonesia_provinces.code')
            ->when($search, function($query) use($search){
                $query->where('indonesia_cities.name', 'LIKE', '%'.$search.'%');
            })
            ->where('indonesia_cities.province_code', $province_code)
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
        $city_code = $request->input('city_code');

        $districts = array();
        $districts = IndonesiaDistrict::query()
            ->join('indonesia_cities', 'indonesia_districts.city_code', '=', 'indonesia_cities.code')
            ->when($search, function($query) use($search){
                $query->where('indonesia_districts.name', 'LIKE', '%'.$search.'%');
            })
            ->where('indonesia_districts.city_code', $city_code)
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
        $district_code = $request->input('district_code');

        $villages = array();
        $villages = IndonesiaVillage::query()
            ->join('indonesia_districts', 'indonesia_villages.district_code', '=', 'indonesia_districts.code')
            ->when($search, function($query) use($search){
                $query->where('indonesia_villages.name', 'LIKE', '%'.$search.'%');
            })
            ->where('indonesia_villages.district_code', $district_code)
            ->select([
                'indonesia_villages.code',
                'indonesia_villages.name',
                'indonesia_districts.name as district_name'
            ])
            ->get();

        return response()->json($villages);
    }
}
