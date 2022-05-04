<?php

namespace Src\Promotions\Domain\Data\TransferObjects;

use Carbon\Carbon;
use Src\Math\Percentage;

class PromotionSetup
{
    private const DEFAULT_MINIMUM_MARGIN = 5.0;

    private function __construct(
        public readonly Carbon $beginDate,
        public readonly Carbon $endDate,
        public readonly Percentage $discount,
        public readonly Percentage $marketplaceSubsidy,
        public readonly Percentage $minimumMargin,
        public readonly string $marketplaceSlug,
        public readonly string $name,
        public readonly int $productsMaxLimit,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            beginDate: $data['beginDate'],
            endDate: $data['endDate'],
            discount: $data['discount'],
            marketplaceSubsidy: $data['marketplaceSubsidy'] ?? Percentage::fromFraction(0),
            minimumMargin: $data['minimumMargin'] ?? Percentage::fromPercentage(self::DEFAULT_MINIMUM_MARGIN),
            marketplaceSlug: $data['marketplaceSlug'],
            name: $data['name'],
            productsMaxLimit: $data['productsMaxLimit'],
        );
    }
}
