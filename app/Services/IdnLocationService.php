<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class IdnLocationService
{
    public function fetchAndFilterData(string $level, ?string $parent = null, ?string $search = null): array
    {
        try {
            $url = 'https://sig.bps.go.id/rest-drop-down/getwilayah?level=' . $level;

            if ($parent) {
                $url .= '&parent=' . $parent;
            }

            $url .= '&periode_merge=2024_1.2022';

            $response = (new Client())->get($url);
            $data = json_decode($response->getBody()->getContents(), true);

            if ($search) {
                $data = array_filter($data ?? [], function ($item) use ($search) {
                    return stripos($item['nama'], $search) !== false; // Case-insensitive search
                });
            }

            return array_values($data ?? []); // Ensure array indexes are reset
        } catch (GuzzleException $exception) {
            Log::error($exception->getMessage());
            return []; // Return empty array in case of error
        }
    }
}
