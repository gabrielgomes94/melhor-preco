<?php

namespace Src\Prices\Infrastructure\Laravel\Presentation\Http\Controllers\Web\Promotions;

use Src\Prices\Domain\Repositories\PromotionsRepository;
use Src\Prices\Infrastructure\Laravel\Presentation\Http\Requests\Promotions\CalculatePromotionRequest;
use Src\Prices\Infrastructure\Laravel\Presentation\Presenters\Promotions\EditPromotionPresenter;
use Src\Prices\Infrastructure\Laravel\Services\Promotions\UpdatePromotion;

class EditPromotionController
{
    public function __construct(
        private PromotionsRepository   $repository,
        private EditPromotionPresenter $presenter,
        private UpdatePromotion        $updatePromotion
    )
    {}

    public function edit(string $promotionUuid)
    {
        $promotion = $this->repository->get($promotionUuid);
        $data = $this->presenter->present($promotion);

        return view('pages.promotions.edit', [
            'promotion' => $data,
        ]);
    }

    public function update(string $promotionUuid, CalculatePromotionRequest $request)
    {
        $this->updatePromotion->update($promotionUuid, $request->transform());

        return redirect()->route('promotions.index');
    }
}
