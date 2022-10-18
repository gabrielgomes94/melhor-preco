<?php

namespace Src\Sales\Application\Reports\Factories;

use Src\Sales\Domain\Repositories\SaleItemsRepository;
use Src\Sales\Infrastructure\Laravel\Services\CalculateItem;

class MostSelledProductsReport
{
    public function __construct(
        private readonly SaleItemsRepository $itemsRepository,
        private readonly CalculateItem $calculateItem,
    )
    {}

    public function report(): array
    {

    }
}
