<?php

namespace App\Services;

use App\Models\Customer;

class StoreCustomer
{
    private string $vendor;
    private string $provider;
    private string $firstName;
    private string $lastName;
    private string $userName;
    private string $customerId;

    public function __construct(string $vendor, string $provider, string $customerId,
                                string $firstName, string $lastName, string $userName)
    {
        $this->vendor = $vendor;
        $this->provider = $provider;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->userName = $userName;
        $this->customerId = $customerId;
    }

    public function run()
    {
        $customer = new Customer();
        $customer->customer_id = $this->customerId;
        $customer->provider = $this->provider;
        $customer->vendor = $this->vendor;
        $customer->first_name = $this->firstName;
        $customer->last_name = $this->lastName;
        $customer->user_name = $this->userName;
        $customer->save();
    }
}
