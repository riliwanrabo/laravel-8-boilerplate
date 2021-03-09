<?php

namespace App\Services\Opay;

use App\Models\Transaction;
use App\Services\Opay\Enums\Response;

class RequeryService
{
    use OpayTrait;

    private string $reference;
    private string $orderNo;

    public function __construct(string $reference, string $orderNo)
    {
        $this->reference = $reference;
        $this->orderNo = $orderNo;
    }

    public function run()
    {
        $endpoint = $this->variables()->baseUrl . '/bills/bulk-status';
        $payload = $this->requestBody();
        $request = $this->post($endpoint, $payload, $this->commonHeaders());

        $response = json_decode($request->body(), false);
        if ($response->code == "0000") {
            // loop through and update references
            $data = $response->data;
            $transactionData = [];
            if (count($data) > 0) {
                foreach ($data as $datum) {
                    $transaction = Transaction::query()->where('order_no', $datum->orderNo)->first();
                    if (!$transaction) {
                        break;
                    }
                    switch ($datum->status) {
                        case Response::PENDING:
                            $transaction->status = 'pending';

                            break;
                        case Response::FAIL:
                            $transaction->status = 'failed';

                            break;
                        case Response::SUCCESS:
                            $transaction->status = 'successful';

                            break;
                        default:
                            $transaction->status = '';

                            break;
                    }
                    $transactionData[] = $transaction;
                }

                return $transactionData;
            }
        }
    }

    public function requestBody(): array
    {
        return [
            "bulkStatusRequest" => [
                [
                    "orderNo" => $this->orderNo,
                    "reference" => $this->reference,
                ],
            ],
            "serviceType" => "betting",
        ];
    }
}
