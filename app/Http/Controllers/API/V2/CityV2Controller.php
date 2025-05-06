<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityRequest;
use App\Jobs\GenerateCityJob;
use App\Models\IndonesiaCity;
use App\Models\IndonesiaProvince;
use App\Services\IdnLocationService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CityV2Controller extends Controller
{
    use ApiResponse;

    protected IdnLocationService $idnLocationService;

    public function __construct(IdnLocationService $idnLocationService)
    {
        $this->idnLocationService = $idnLocationService;
    }

    public function index(CityRequest $request): JsonResponse
    {
        $provinceCode = $request->input('province_code');
        $search = $request->query('search');
        $data = $this->idnLocationService->fetchAndFilterData('kabupaten', $provinceCode, $search);

        return $this->apiResponse('Get data success', $data, Response::HTTP_OK);
    }

    public function show(IndonesiaCity $indonesiaCity): View
    {
        $indonesiaCity->load([
            'indonesiaDistricts' => fn($query) => $query->withCount('indonesiaVillages')
        ]);

        return \view('idn-location.city', compact('indonesiaCity'));
    }

    public function store()
    {
        try {
            $provinces = IndonesiaProvince::get();
            foreach ($provinces as $province) {
                $cities = $this->idnLocationService->fetchAndFilterData('kabupaten', $province->code);
                foreach ($cities as $city) {
                    GenerateCityJob::dispatch($province, $city['kode'], $city['nama']);
                }
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Internal server error');
        }

        return redirect()->back()->with('success', 'Data has ben saved');
    }
}
