<?php

namespace Src\Sales\Domain\Factories;

use Src\Sales\Infrastructure\Laravel\Models\Customer as CustomerModel;
use Src\Sales\Domain\Models\ValueObjects\Customer\Customer as CustomerData;

class Customer
{
    public static function make(CustomerModel $model): CustomerData
    {
        return new CustomerData(
            name: $model->name,
            fiscalId: $model->fiscal_id,
            phones: $model->phones,
            address: Address::make($model->address),
            documentNumber: $model->document_number,
        );
    }

    public static function makeModel(CustomerData $customer)
    {
        return new CustomerModel([
            'name' => $customer->getName(),
            'fiscal_id' => $customer->getFiscalId(),
            'document_number' => $customer->getDocumentNumber(),
            'phones' => $customer->getPhones()
        ]);
    }
}
