<?php

namespace Tests\Data\Models\Sales;

use Src\Sales\Infrastructure\Laravel\Models\Customer;

class CustomerData
{
    public static function persisted(array $data = []): Customer
    {
        $data = array_merge([
            'name' => 'João da Silva',
            'fiscal_id' => '',
            'phones' => ['+5511987654321']

        ], $data);
        $customer = new Customer($data);
        $customer->save();

        return $customer;
    }
}
