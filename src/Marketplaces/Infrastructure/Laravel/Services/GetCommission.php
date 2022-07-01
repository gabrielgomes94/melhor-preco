<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Services;

use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Domain\Services\GetCommission as GetCommissionInterface;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Users\Domain\Entities\User;

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

    public function get(string $marketplaceErpId, string $productSku, string $userId): float
    {
        $marketplace = $this->marketplaceRepository->getByErpId($marketplaceErpId);

        if ($marketplace->hasUniqueCommission()) {
            return $marketplace->getUniqueCommission()->getFraction();
        }

        if ($marketplace->hasCommissionByCategory()) {
            $product = $this->productRepository->get($productSku, $userId);

            return $marketplace->getCommissionByCategory(
                $product->getCategoryId()
            )?->getFraction() ?? 0.0;
        }

        return 0.0;
    }

    public function getFromPrice(Price $price, User $user): float
    {
        return $this->get(
            $price->getMarketplaceErpId(),
            $price->getProductSku(),
            $user->getId()
        );
    }
}
