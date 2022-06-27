<?php

namespace Src\Prices\Infrastructure\Laravel\Presentation\Presenters\Promotions;

use Src\Prices\Domain\Models\Promotion;

class ListPromotionsPresenter
{
    public function present(iterable $promotions): array
    {
        foreach ($promotions as $promotion) {
            if (!$promotion instanceof Promotion) {
                throw new \Error('promotion is not from Promotion type');
            }

            $presented[] = [
                'name' => $promotion->getName(),
                'discount' => $promotion->getDiscount(),
                'marketplace' => $promotion->getMarketplace(),
                'beginDate' => $promotion->getBeginDate()->format('d-m-Y'),
                'endDate' => $promotion->getEndDate()->format('d-m-Y'),
                'uuid' => $promotion->getUuid()
            ];
        }

        return $presented ?? [];
    }
}
