<?php

namespace Src\Products\Domain\Models\Post;

use Money\Money;
use Src\Calculator\Domain\Models\Price\Price as CalculatedPrice;
use Src\Calculator\Domain\Transformer\PercentageTransformer;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Prices\Domain\Models\Price as PriceModel;
use Src\Products\Domain\Models\Post\Identifiers\Identifiers;
use Src\Products\Domain\Models\Post\Identifiers\Identifiers as PostIdentifiers;
use Src\Products\Domain\Models\Product\Contracts\Post as PostInterface;
use Src\Products\Domain\Models\Product\Product;

class Post implements PostInterface
{
    protected CalculatedPrice $calculatedPrice;
    protected PriceModel $priceModel;

    public function __construct(
        PriceModel      $priceModel,
        CalculatedPrice $calculatedPrice
    ) {
        $this->priceModel = $priceModel;
        $this->calculatedPrice = $calculatedPrice;
    }

    public function getId(): string
    {
        return $this->getIdentifiers()->getId();
    }

    public function getIdentifiers(): Identifiers
    {
        return new PostIdentifiers(
            $this->priceModel->getId(),
            $this->priceModel->getStoreSkuId(),
        );
    }

    public function getMarketplace(): Marketplace
    {
        return $this->priceModel->getMarketplace();
    }

    public function getCalculatedPrice(): CalculatedPrice
    {
        return $this->calculatedPrice;
    }

    public function getPrice(): PriceModel
    {
        return $this->priceModel;
    }

    public function getPriceModel(): PriceModel
    {
        return $this->priceModel;
    }

    public function getProduct(): Product
    {
        return $this->priceModel->getProduct();
    }

    public function isProfitable(): bool
    {
        return $this->price->getProfit()->greaterThanOrEqual(Money::BRL(0));
    }

    public function isInMarginRange(float $minimumProfit, float $maximumProfit)
    {
        $minimumProfit = PercentageTransformer::toPercentage($minimumProfit);
        $maximumProfit = PercentageTransformer::toPercentage($maximumProfit);
        $margin = $this->getPrice()->getMargin();

        return $minimumProfit <= $margin && $margin <= $maximumProfit;
    }
}
