<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Prices;

use Illuminate\Support\Facades\Log;
use Src\Prices\Domain\Services\CalculateProfit;
use Src\Integrations\Bling\Products\Requests\Config;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Prices\Infrastructure\Laravel\Repositories\PriceRepository;
use Src\Products\Infrastructure\Bling\ProductRepository as BlingRepository;
use Src\Products\Infrastructure\Bling\Responses\Prices\PricesCollectionResponse;
use Src\Users\Infrastructure\Laravel\Models\User;

class SynchronizeFromMarketplace
{
    public function __construct(
        private BlingRepository $erpRepository,
        private CalculateProfit $calculateProfit,
        private CommissionRepository $commissionRepository,
        private PriceRepository $priceRepository
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

        $count = count($prices->data());
        Log::info("Marketplaces {$marketplace->getName()} - $count preços");

        if (empty($prices->data())) {
            return false;
        }

        $this->save($prices, $user);

        return true;
    }

    public function save(PricesCollectionResponse $prices, User $user): void
    {
        /**
         * @var Price $price
         */
        foreach ($prices->data() as $price) {
            $priceModels = $this->priceRepository->getPriceFromMarketplace(
                $price->store, $price->store_sku_id, $price->product_sku, $user->getId()
            );
            $commission = $this->commissionRepository->get(
                $price->getMarketplace(),
                $price->getProduct()
            );
            $profit = $this->calculateProfit->fromModel($price, $user);

            if ($priceModels->count() === 0) {
                $this->priceRepository->insert($price, $commission->get(), $profit, $user->getId());

                continue;
            }

            foreach ($priceModels as $priceModel) {
                $this->priceRepository->update($priceModel, $price->value, $profit, $commission->get());
            }
        }
    }
}
