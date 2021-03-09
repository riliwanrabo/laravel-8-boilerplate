<?php

namespace App\Services\Opay;

use App\Models\Transaction;

class TransactionService
{
    use OpayTrait;

    private string $reference;
    private float $amount;
    private string $provider;
    private string $customerId;

    public function __construct(string $reference, float $amount, string $provider, string $customerId)
    {
        $this->reference = $reference;
        $this->amount = $amount;
        $this->provider = $provider;
        $this->customerId = $customerId;
    }

    public function run()
    {
        $endpoint = $this->variables()->baseUrl . '/bills/bulk-bills';
        $payload = $this->requestBody();
        $request = $this->post($endpoint, $payload, $this->commonHeaders($payload, true));
        $response = json_decode($request->body(), false);
        if ($response->code == "0000") {
            $response = [
                'reference' => $response->data[0]->reference,
                'orderNo' => $response->data[0]->orderNo,
                'status' => $response->data[0]->status,
            ];
            // log transaction/response
            // TODO: seperate logic
            $transaction = new Transaction();
            $transaction->reference = $response['reference'];
            $transaction->order_no = $response['orderNo'];
            $transaction->status = $response['status'];

            $transaction->save();

            return $response;
        }
        throw new \RuntimeException($response->message);
    }

    private function requestBody(): array
    {
        $amount = $this->amount * 100;
        $callbackUrl = (route('opay-bet-callback', ['reference' => $this->reference]));
        return [
            "bulkData" => [
                [
                    "amount" => (string)$amount,
                    "country" => "NG",
                    "currency" => "NGN",
                    "customerId" => $this->customerId,
                    "provider" => $this->provider,
                    "reference" => $this->reference,
                ],
            ],
            "callBackUrl" => "",
            "serviceType" => "betting",
        ];
    }
}
