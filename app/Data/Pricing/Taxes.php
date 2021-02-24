<?php


namespace App\Data\Pricing;


use Spatie\DataTransferObject\DataTransferObject;

class Taxes extends DataTransferObject
{
    public float $ipi;

    public float $icmsDifference;

    public float $simplesNacional;
}
