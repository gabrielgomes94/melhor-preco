<?php

namespace Src\Promotions\Infrastructure\Laravel\Http\Controllers;

use Src\Promotions\Domain\Repositories\Repository;
use Src\Promotions\Domain\UseCases\UpdatePromotion;
use Src\Promotions\Infrastructure\Laravel\Http\Requests\CalculatePromotionRequest;
use Src\Promotions\Infrastructure\Laravel\Presenters\EditPromotionPresenter;

class EditPromotionController
{
    public function __construct(
        private Repository $repository,
        private EditPromotionPresenter $presenter,
        private UpdatePromotion $updatePromotion
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
