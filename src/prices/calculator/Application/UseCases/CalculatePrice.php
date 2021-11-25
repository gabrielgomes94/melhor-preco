<?php

namespace Src\Prices\Calculator\Application\UseCases;

use Src\Prices\Calculator\Domain\Services\Contracts\SimulatePost;
use Src\Prices\Calculator\Domain\UseCases\Contracts\CalculatePrice as CalculatePriceInterface;
use Src\Prices\Calculator\Presentation\Presenters\PricePresenter;

class CalculatePrice implements CalculatePriceInterface
{
    private SimulatePost $service;
    private PricePresenter $presenter;

    public function __construct(SimulatePost $service, PricePresenter $presenter)
    {
        $this->service = $service;
        $this->presenter = $presenter;
    }

    public function calculate(array $data): array
    {
        $post = $this->service->calculate($data);

        return $this->presenter->transform($post);
    }
}
