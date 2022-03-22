<?php

namespace Src\Promotions\Infrastructure\Laravel\Presenters;

class ListPromotionsPresenter
{
    public function present(iterable $promotions): array
    {
        foreach ($promotions as $promotion) {
            $presented[] = [
                'name' => $promotion->getName(),
                'discount' => $promotion->getDiscount(),
                'marketplace' => $promotion->getMarketplace(),
                'beginDate' => $promotion->getBeginDate()->format('d-m-Y'),
                'endDate' => $promotion->getEndDate()->format('d-m-Y'),
            ];
        }

        return $presented ?? [];
    }
}
