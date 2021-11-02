<?php


namespace Src\Sales\Domain\Factories;


use Src\Sales\Domain\Models\Customer as CustomerModel;
use Src\Sales\Domain\Models\Data\Customer\Customer as CustomerData;

class Customer
{
    public static function make(CustomerData $customer)
    {
        return new CustomerModel([
            'name' => $customer->getName(),
            'fiscal_id' => $customer->getFiscalId(),
            'document_number' => $customer->getDocumentNumber(),
            'phones' => $customer->getPhones()
        ]);
    }
}
