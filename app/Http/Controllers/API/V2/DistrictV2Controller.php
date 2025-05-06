<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistrictRequest;
use App\Jobs\GenerateDistrictJob;
use App\Models\IndonesiaCity;
use App\Services\IdnLocationService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
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

    public function store(): JsonResponse
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
            return $this->apiResponse('Internal server error', null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data has ben saved', null, Response::HTTP_OK);
    }
}
