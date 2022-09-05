<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Prices;

use Illuminate\Support\Facades\Log;
use Src\Prices\Infrastructure\Laravel\Services\Prices\CalculateProfit;
use Src\Integrations\Bling\Products\Requests\Config;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Prices\Infrastructure\Laravel\Repositories\PricesRepository;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Products\Infrastructure\Bling\ProductRepository as BlingRepository;
use Src\Products\Infrastructure\Bling\Responses\Prices\PricesCollectionResponse;
use Src\Users\Infrastructure\Laravel\Models\User;

class SynchronizeFromMarketplace
{
    public function __construct(
        private BlingRepository      $erpRepository,
        private CalculateProfit      $calculateProfit,
        private CommissionRepository $commissionRepository,
        private PricesRepository     $priceRepository,
        private ProductRepository    $productRepository
    ) {
    }

    public function sync(Marketplace $marketplace, int $page = 1, string $status = Config::ACTIVE): bool
    {
        $user = $marketplace->getUser();

        $prices = $this->erpRepository->allInMarketplace(
            $user->getErpToken(),
            $marketplace,
            $status,
            $page
        );

        if (empty($prices->data())) {
            return false;
        }

        $this->save($prices, $user, $marketplace);

        return true;
    }

    public function save(PricesCollectionResponse $prices, User $user, Marketplace $marketplace): void
    {
        /**
         * @var Price $price
         */
        foreach ($prices->data() as $price) {
            $priceModels = $this->priceRepository->getPriceFromMarketplace($marketplace, $price->getProductSku());
            $product = $this->productRepository->get($price->getProductSku(), $user->getId());

            if (!$product) {
                continue;
            }

            $commission = $this->commissionRepository->getCommissionRate($marketplace, $product);
            $profit = $this->calculateProfit->fromModel($price, $product, $marketplace);

            if ($priceModels->count() === 0) {
                $this->priceRepository->insert($price, $product, $marketplace, $commission->get(), $profit);

                continue;
            }

            foreach ($priceModels as $priceModel) {
                $this->priceRepository->update($priceModel, $price->getValue(), $profit, $commission->get());
            }
        }
    }
}
