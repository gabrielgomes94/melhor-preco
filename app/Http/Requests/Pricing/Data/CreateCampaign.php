<?php

namespace App\Http\Requests\Pricing\Data;

use Spatie\DataTransferObject\DataTransferObject;

class CreateCampaign extends DataTransferObject
{
    public string $name;

    public array $skuList;

    public array $stores;
}
