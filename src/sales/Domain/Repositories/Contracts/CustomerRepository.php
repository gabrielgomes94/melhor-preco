<?php

namespace Src\Sales\Domain\Repositories\Contracts;

use Src\Sales\Domain\Models\Customer as CustomerModel;
use Src\Sales\Domain\Models\ValueObjects\Customer\Customer as CustomerData;

interface CustomerRepository
{
    public static function create(CustomerData $customer): CustomerModel;
}
