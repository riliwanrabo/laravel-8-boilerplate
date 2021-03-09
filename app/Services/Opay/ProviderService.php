<?php /** @noinspection ALL */

namespace App\Services\Opay;

class ProviderService
{
    use OpayTrait;

    public function run()
    {
        $endpoint = $this->variables()->baseUrl . '/bills/betting-providers';
        $request = $this->post($endpoint, [], $this->commonHeaders());

        $response = json_decode($request->body(), false);
        if ($response->code == "0000") {
            return collect($response->data)->map(function ($res) {
                return [
                    'provider' => $res->provider,
                    'logo_url' => $res->providerLogoUrl,
                ];
            });
        }

        throw new \RuntimeException($response->message);
    }
}
