<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistrictRequest;
use App\Services\IdnLocationService;
use App\Traits\ApiResponse;
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
}
