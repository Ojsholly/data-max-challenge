<?php

namespace App\Services;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class ExternalBookService
{
    public function search(array $data = []): array
    {
        $response = Http::retry(3, 100)->get(config('services.resource.url') . '/books', $data)->json();

        return $response;
    }
}