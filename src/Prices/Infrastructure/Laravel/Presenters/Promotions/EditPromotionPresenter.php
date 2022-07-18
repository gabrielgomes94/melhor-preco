<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters\Promotions;

use Src\Prices\Domain\Models\Promotion;

class EditPromotionPresenter
{
    public function present(Promotion $promotion): array
    {
        return [
            'name' => $promotion->getName(),
            'beginDate' => $promotion->getBeginDate()->format('d/m/Y'),
            'endDate' => $promotion->getEndDate()->format('d/m/Y'),
            'discount' => $promotion->getDiscount()->get(),
            'uuid' => $promotion->getUuid(),
            'maxProductsLimit' => $promotion->getProductsLimit(),
            'marketplaceSubsidy' => $promotion->getMarketplaceSubsidy()->get(),
        ];
    }
}
