<?php

namespace Src\Promotions\Domain\UseCases\Contracts;

use Src\Promotions\Domain\Data\TransferObjects\PromotionSetup;
use Src\Promotions\Domain\Data\Entities\Promotion;

interface CalculatePromotions
{
    public function calculate(PromotionSetup $data): Promotion;
}
