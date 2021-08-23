<?php

namespace Barrigudinha\SaleOrder\Entities;

use Barrigudinha\SaleOrder\ValueObjects\Address;
use Barrigudinha\SaleOrder\ValueObjects\Invoice;
use Barrigudinha\SaleOrder\ValueObjects\Items;
use Barrigudinha\SaleOrder\ValueObjects\Payment;
use Carbon\Carbon;

class SaleOrder
{
    private string $id;
    private Carbon $date;

    private Customer $customer;
    private Address $deliveryAddess;
    private Invoice $invoice;
    private Payment $payment;
    private Items $items;
//    private
}
