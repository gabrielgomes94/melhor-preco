<?php

namespace Src\Promotions\Infrastructure\Laravel\Http\Controllers;

use Src\Promotions\Domain\UseCases\Contracts\ListPromotions;
use Src\Promotions\Infrastructure\Laravel\Presenters\ListPromotionsPresenter;

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
