<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Collections;

use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\DataTransfer\Collections\CommissionValues as CommissionValuesCollectionInterface;
use Src\Marketplaces\Domain\DataTransfer\CommissionValue;

class CommissionValues extends Collection implements CommissionValuesCollectionInterface
{
    public function __construct($items = [])
    {
        foreach($items as $item) {
            if ($item instanceof CommissionValue) {
                $data[] = $item;
            }
        }

        parent::__construct($data ?? []);
    }
}
