<?php

namespace Src\Notifications\Domain\Rules;

use Src\Notifications\Domain\Contracts\Rules\Rule;
use Src\Prices\Price\Infrastructure\Repositories\Repository as PriceRepository;

class UnprofitablePrice implements Rule
{
    private PriceRepository $repository;

    public function __construct(PriceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function isSolved(array $data): bool
    {
        $priceId = $data['content']['priceId'];
        $price = $this->repository->get($priceId);

        return $price->isProfitable();
    }
}
