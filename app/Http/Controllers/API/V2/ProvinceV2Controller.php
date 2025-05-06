<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProvinceRequest;
use App\Models\IndonesiaProvince;
use App\Services\GenerateData\GenerateProvinceService;
use App\Services\IdnLocationService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
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

    public function show(IndonesiaProvince $indonesiaProvince): View
    {
        $indonesiaProvince->load([
            'indonesiaCities' => fn($query) => $query->withCount('indonesiaDistricts')
        ]);

        return \view('idn-location.province', compact('indonesiaProvince'));
    }

    public function index(ProvinceRequest $request): JsonResponse
    {
        $search = $request->query('search');
        $data = $this->idnLocationService->fetchAndFilterData('provinsi', null, $search);

        return $this->apiResponse('Get data success', $data, Response::HTTP_OK);
    }

    public function store()
    {
        try {
            $this->generateProvinceService->saveData($this->idnLocationService->fetchAndFilterData('provinsi'));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Internal server error');
        }

        return redirect()->back()->with('success', 'Data has ben saved');
    }
}
