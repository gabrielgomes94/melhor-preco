<?php

namespace Src\Promotions\Domain\UseCases\Contracts;

use Src\Promotions\Domain\Data\PromotionSetup;
use Src\Promotions\Domain\Models\Promotion;

interface CalculatePromotions
{
    public function calculate(PromotionSetup $data): Promotion;
}
