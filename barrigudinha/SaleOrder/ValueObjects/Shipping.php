<?php

namespace Barrigudinha\SaleOrder\ValueObjects;

class Shipping
{
    private string $shippingCompany;
    private string $fiscalId;
    private string $type;
    private Volumes $volumes;
    private Address $deliveryAddress;
}
