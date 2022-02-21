<?php

namespace Src\Calculator\Application\UseCases;

use Src\Calculator\Domain\Services\Contracts\SimulatePost;
use Src\Calculator\Domain\UseCases\Contracts\CalculatePrice as CalculatePriceInterface;
use Src\Calculator\Presentation\Presenters\PricePresenter;

class CalculatePrice implements CalculatePriceInterface
{
    private SimulatePost $service;
    private PricePresenter $presenter;

    public function __construct(SimulatePost $service, PricePresenter $presenter)
    {
        $this->service = $service;
        $this->presenter = $presenter;
    }

    //@todo: retirar o presenter daqui. Simplificar o Service(talvez o simulate post não seja mais necessário)
    public function calculate(array $data): array
    {
        $post = $this->service->calculate($data);

        return $this->presenter->transform($post);
    }
}
