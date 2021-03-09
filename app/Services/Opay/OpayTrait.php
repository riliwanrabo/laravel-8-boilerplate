<?php

namespace App\Services\Opay;

use App\Traits\CurlTrait;

trait OpayTrait
{
    use CurlTrait;

    public function variables()
    {
        return (object)[
            'baseUrl' => env('OPAY_BASE_URL'),
            'key' => env('OPAY_SECRET_KEY')
        ];
    }

    protected function hash($payload): string
    {
        $key = $this->variables()->key;
        return hash_hmac('SHA512', json_encode($payload), $key);
    }

    public function commonHeaders($payload = [], bool $signature = false): array
    {

        return [
            'Authorization' => $signature ? 'Bearer ' . $this->hash($payload) : 'Bearer ' . env('OPAY_PUBLIC_KEY'),
            'MerchantId' => env('OPAY_MERCHANT_ID'),
        ];
    }

}
