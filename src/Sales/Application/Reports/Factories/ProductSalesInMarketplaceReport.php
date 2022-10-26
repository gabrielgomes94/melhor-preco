<?php

namespace Src\Sales\Application\Reports\Factories;

use Carbon\Carbon;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Sales\Application\Repositories\MarketplaceSalesRepository;
use Src\Sales\Application\Reports\Data\Marketplace\MarketplaceSales;

class ProductSalesInMarketplaceReport
{
    public function __construct(
        private readonly MarketplaceRepository $marketplaceRepository,
        private readonly MarketplaceSalesRepository $marketplaceSalesRepository,
        private readonly ProductRepository $productRepository
    )
    {}

    /**
     * @return MarketplaceSales[]
     */
    public function report(
        string $sku,
        string $userId,
        ?Carbon $beginDate = null,
        ?Carbon $endDate = null
    ): array
    {
        $marketplaces = $this->marketplaceRepository->list($userId);
        $marketplaces = collect($marketplaces);

        $product = $this->productRepository->get($sku, $userId);

        if (!$product) {
            throw new ProductNotFoundException($sku, $userId);
        }

        return $marketplaces->map(
            fn (Marketplace $marketplace) => $this->marketplaceSalesRepository->getSalesByProduct(
                $product,
                $marketplace,
                $beginDate,
                $endDate
            )
        )->all();
    }
}
