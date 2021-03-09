<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait CurlTrait
{
    public function get($url, array $params = [], array $headers = [])
    {
        return Http::withHeaders($headers)
            ->get($url, $params);
    }

    public function post($url, array $requestBody = [], array $headers = [])
    {
        return Http::withHeaders($headers)
            ->post($url, $requestBody);
    }
}
