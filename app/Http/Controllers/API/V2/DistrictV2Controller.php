<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistrictRequest;
use App\Jobs\GenerateDistrictJob;
use App\Models\IndonesiaCity;
use App\Models\IndonesiaDistrict;
use App\Services\IdnLocationService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DistrictV2Controller extends Controller
{
    use ApiResponse;

    protected IdnLocationService $idnLocationService;

    /**
     * @param IdnLocationService $idnLocationService
     */
    public function __construct(IdnLocationService $idnLocationService)
    {
        $this->idnLocationService = $idnLocationService;
    }

    public function index(DistrictRequest $request): JsonResponse
    {
        $cityCode = $request->input('city_code');
        $search = $request->query('search');
        $data = $this->idnLocationService->fetchAndFilterData('kecamatan', $cityCode, $search);

        return $this->apiResponse('Get data success', $data, Response::HTTP_OK);
    }

    public function show(IndonesiaDistrict $indonesiaDistrict): View
    {
        $indonesiaDistrict->load('indonesiaVillages');

        return \view('idn-location.district', compact('indonesiaDistrict'));
    }

    public function store()
    {
        try {
            $cities = IndonesiaCity::get();
            foreach ($cities as $city) {
                $districts = $this->idnLocationService->fetchAndFilterData('kecamatan', $city->code);
                foreach ($districts as $district) {
                    GenerateDistrictJob::dispatch($city->code, $district['kode'], $district['nama']);
                }
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Internal server error');
        }

        return redirect()->back()->with('success', 'Data has ben saved');
    }
}
