<?php

namespace Src\Promotions\Domain\UseCases;

use Src\Promotions\Domain\Repositories\PromotionRepository;
use Src\Promotions\Domain\UseCases\Contracts\ListPromotions as ListPromotionsInterface;

class ListPromotions implements ListPromotionsInterface
{
    public function __construct(
        private PromotionRepository $promotionRepository
    )
    {}

    public function list(): array
    {
        return $this->promotionRepository->list();
    }
}
