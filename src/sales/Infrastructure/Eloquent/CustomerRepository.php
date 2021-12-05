<?php

namespace Src\Sales\Infrastructure\Eloquent;

use Src\Sales\Domain\Factories\Address as AddressFactory;
use Src\Sales\Domain\Factories\Customer as CustomerFactory;
use Src\Sales\Domain\Models\Customer as CustomerModel;
use Src\Sales\Domain\Models\ValueObjects\Customer\Customer as CustomerData;
use Src\Sales\Domain\Repositories\Contracts\CustomerRepository as CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    public static function create(CustomerData $customer): CustomerModel
    {
        $address = AddressFactory::makeModel($customer->getAddress());
        $customerModel = CustomerFactory::makeModel($customer);
        $customerModel->save();
        $customerModel->address()->save($address);

        return $customerModel;
    }
}
