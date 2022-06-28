<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Services;

use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Domain\UseCases\Contracts\GetCommission as GetCommissionInterface;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Domain\Repositories\ProductRepository;

class GetCommission implements GetCommissionInterface
{
    private MarketplaceRepository $marketplaceRepository;
    private ProductRepository $productRepository;

    public function __construct(
        MarketplaceRepository $marketplaceRepository,
        ProductRepository $productRepository
    ) {
        $this->marketplaceRepository = $marketplaceRepository;
        $this->productRepository = $productRepository;
    }

    public function get(string $marketplaceErpId, string $productSku): float
    {
        $marketplace = $this->marketplaceRepository->getByErpId($marketplaceErpId);
        $product = $this->productRepository->get($productSku);

        if ($marketplace->hasUniqueCommission()) {
            return $marketplace->getUniqueCommission()->getFraction();
        }

        if ($marketplace->hasCommissionByCategory()) {
            return $marketplace->getCommissionByCategory(
                $product->getCategoryId()
            )?->getFraction() ?? 0.0;
        }

        return 0.0;
    }

    public function getFromPrice(Price $price): float
    {
        return $this->get(
            $price->getMarketplaceErpId(),
            $price->getProductSku()
        );
    }
}
