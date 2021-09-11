<?php

namespace Barrigudinha\SaleOrder\ValueObjects;

use Barrigudinha\Product\Data\Dimensions;
use Carbon\Carbon;

class Volume
{
    private string $id;
    private string $idService;
    private string $service;
    private string $serviceCode;
    private string $trackingCode;
    private Carbon $dispatchedAt;
    private int $expectedDeliveryDays;
    private float $expectedFreightValue;
    private float $declaredValue;
    private string $shipmentNumber;
    private string $shipmentCreatedAt;
    private Dimensions $dimensions;
}
