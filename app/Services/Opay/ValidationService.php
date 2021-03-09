<?php /** @noinspection ALL */

namespace App\Services\Opay;

class ValidationService
{
    use OpayTrait;

    private string $provider;
    private string $customerId;

    public function __construct(string $provider, string $customerId)
    {
        $this->provider = $provider;
        $this->customerId = $customerId;
    }

    public function run()
    {
        $endpoint = $this->variables()->baseUrl . '/bills/validate';
        $payload = $this->requestBody();
        $request = $this->post($endpoint, $payload, $this->commonHeaders());
        $response = json_decode($request->body(), false);

        if ($response->code == "0000") {
            return [
                'customer_id' => $response->data->customerId,
                'provider' => $response->data->provider,
                'first_name' => $response->data->firstName,
                'last_name' => $response->data->lastName,
                'user_name' => $response->data->userName,
            ];
        }

        throw new \RuntimeException($response->message);
    }

    private function requestBody(): array
    {
        return [
            "serviceType" => "betting",
            "provider" => $this->provider,
            "customerId" => $this->customerId
        ];
    }
}
