<?php

namespace Src\Prices\Domain\UseCases\Promotions;

use Src\Prices\Domain\DataTransfer\PromotionSetup;
use Src\Prices\Domain\Models\Promotion;

interface CalculatePromotions
{
    public function calculate(PromotionSetup $data): Promotion;
}
