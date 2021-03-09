<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Opay\ProviderService;
use App\Services\Opay\RequeryService;
use App\Services\Opay\TransactionService;
use App\Services\Opay\ValidationService;
use Illuminate\Http\Request;

class BettingController extends Controller
{
    public function __construct()
    {
    }

    public function fetchProviders()
    {
        try {
            $providers = (new ProviderService())->run();
        } catch (\Exception $e) {
            return $this->helper()->responder([], 400, $e->getMessage());
        }

        return $this->helper()->responder($providers, 200);
    }

    public function inquire(Request $request)
    {
        $provider = $request->get('provider');
        $customerId = $request->get('customer_id');

        try {
            $customerInfo = (new ValidationService($provider, $customerId))->run();
        } catch (\Exception $e) {
            return $this->helper()->responder([], 400, $e->getMessage());
        }

        return $this->helper()->responder($customerInfo, 200);
    }

    public function transact(Request $request)
    {
        $reference = $this->helper()->transactionReference();
        $provider = $request->get('provider');
        $amount = $request->get('amount');
        $customerId = $request->get('customer_id');

        try {
            $providers = (new TransactionService($reference, $amount, $provider, $customerId))->run();
        } catch (\Exception $e) {
            return $this->helper()->responder([], 400, $e->getMessage());
        }

        return $this->helper()->responder($providers, 200);
    }

    public function callback($reference)
    {
    }

    public function requery(Request $request)
    {
        $reference = $request->reference;
        $orderNo = $request->order_no;

        try {
            $reQuery = (new RequeryService($reference, $orderNo))->run();
        } catch (\Exception $e) {
            return $this->helper()->responder([], 400, $e->getMessage());
        }

        return $this->helper()->responder($reQuery, 200);
    }
}
