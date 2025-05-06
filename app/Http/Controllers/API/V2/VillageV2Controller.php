<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\VillageRequest;
use App\Jobs\GenerateVillageJob;
use App\Models\IndonesiaDistrict;
use App\Services\IdnLocationService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
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

    public function store()
    {
        try {
            $districts = IndonesiaDistrict::get();
            foreach ($districts as $district) {
                $villages = $this->idnLocationService->fetchAndFilterData('desa', $district->code);
                foreach ($villages as $village) {
                    GenerateVillageJob::dispatch($district->code, $village['kode'], $village['nama']);
                }
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Internal server error');
        }

        return redirect()->back()->with('success', 'Data has ben saved');
    }
}
