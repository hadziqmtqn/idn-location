<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityRequest;
use App\Traits\ApiResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CityV2Controller extends Controller
{
    use ApiResponse;

    public function index(CityRequest $request): JsonResponse
    {
        try {
            $response = (new Client())->get('https://sig.bps.go.id/rest-drop-down/getwilayah?level=kabupaten&parent='. $request->input('province_code') .'&periode_merge=2024_1.2022');
            $response = json_decode($response->getBody()->getContents(), true);

            $search = $request->query('search');
            $data = $response ?? [];

            if ($search) {
                $data = array_filter($data, function ($item) use ($search) {
                    return stripos($item['nama'], $search) !== false; // Case-insensitive search
                });
            }

            return $this->apiResponse('Get data success', array_values($data), Response::HTTP_OK);
        } catch (GuzzleException $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
