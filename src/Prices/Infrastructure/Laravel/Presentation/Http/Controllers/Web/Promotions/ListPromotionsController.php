<?php

namespace Src\Prices\Infrastructure\Laravel\Presentation\Http\Controllers\Web\Promotions;

use Src\Prices\Domain\UseCases\Promotions\ListPromotions;
use Src\Prices\Infrastructure\Laravel\Presentation\Presenters\Promotions\ListPromotionsPresenter;

class ListPromotionsController
{
    public function __construct(
        private ListPromotions $listPromotions,
        private ListPromotionsPresenter $presenter,
    )
    {}

    public function __invoke()
    {
        $promotions = $this->listPromotions->list();

        return view('pages.promotions.list', [
            'promotions' => $this->presenter->present($promotions),
        ]);
    }
}