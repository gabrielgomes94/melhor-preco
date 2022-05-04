<?php

namespace Src\Promotions\Domain\Data\Entities;

use DateTime;
use Src\Math\Percentage;

interface Promotion
{
    public function getProducts();

    public function getName(): string;

    public function getDiscount(): Percentage;

    public function getBeginDate(): DateTime;

    public function getEndDate(): DateTime;

    public function getProductsLimit(): int;

    public function getMarketplaceSubsidy(): Percentage;
}
