<?php

namespace Src\Promotions\Infrastructure\Laravel\Http\Controllers;

use Src\Promotions\Domain\Repositories\PromotionRepository;
use Src\Promotions\Infrastructure\Laravel\Presenters\ShowPromotionPresenter;

class ShowPromotionController
{
    public function __construct(
        private PromotionRepository    $repository,
        private ShowPromotionPresenter $presenter
    )
    {}

    public function __invoke(string $promotionUuid)
    {
        $promotion = $this->repository->get($promotionUuid);
        $data = $this->presenter->present($promotion);

        return view('pages.promotions.show', [
            'promotion' => $data,
        ]);
    }
}
