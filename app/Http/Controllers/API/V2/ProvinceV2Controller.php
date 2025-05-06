<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProvinceRequest;
use App\Services\GenerateData\GenerateProvinceService;
use App\Services\IdnLocationService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProvinceV2Controller extends Controller
{
    use ApiResponse;

    protected IdnLocationService $idnLocationService;
    protected GenerateProvinceService $generateProvinceService;

    /**
     * @param IdnLocationService $idnLocationService
     * @param GenerateProvinceService $generateProvinceService
     */
    public function __construct(IdnLocationService $idnLocationService, GenerateProvinceService $generateProvinceService)
    {
        $this->idnLocationService = $idnLocationService;
        $this->generateProvinceService = $generateProvinceService;
    }

    public function index(ProvinceRequest $request): JsonResponse
    {
        $search = $request->query('search');
        $data = $this->idnLocationService->fetchAndFilterData('provinsi', null, $search);

        return $this->apiResponse('Get data success', $data, Response::HTTP_OK);
    }

    public function store(): JsonResponse
    {
        try {
            $this->generateProvinceService->saveData($this->idnLocationService->fetchAndFilterData('provinsi'));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data has ben saved', null, Response::HTTP_OK);
    }
}
