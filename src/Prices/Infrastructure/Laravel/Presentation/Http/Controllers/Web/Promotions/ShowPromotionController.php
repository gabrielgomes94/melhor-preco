<?php

namespace Src\Prices\Infrastructure\Laravel\Presentation\Http\Controllers\Web\Promotions;

use Src\Prices\Domain\Repositories\PromotionsRepository;
use Src\Prices\Infrastructure\Laravel\Presentation\Presenters\Promotions\ShowPromotionPresenter;

class ShowPromotionController
{
    public function __construct(
        private PromotionsRepository   $repository,
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
