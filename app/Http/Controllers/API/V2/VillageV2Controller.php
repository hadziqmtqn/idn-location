<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\VillageRequest;
use App\Services\IdnLocationService;
use App\Traits\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class VillageV2Controller extends Controller
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

    public function index(VillageRequest $request): JsonResponse
    {
        $districtCode = $request->input('district_code');
        $search = $request->query('search');
        $data = $this->idnLocationService->fetchAndFilterData('desa', $districtCode, $search);

        return $this->apiResponse('Get data success', $data, Response::HTTP_OK);
    }
}
