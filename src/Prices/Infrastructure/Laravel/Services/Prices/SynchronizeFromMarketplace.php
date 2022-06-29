<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Prices;

use Src\Calculator\Application\Services\CalculateProfit;
use Src\Integrations\Bling\Products\Requests\Config;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Marketplaces\Domain\UseCases\Contracts\GetCommission;
use Src\Prices\Infrastructure\Laravel\Repositories\PriceRepository;
use Src\Products\Infrastructure\Bling\ProductRepository as BlingRepository;
use Src\Products\Infrastructure\Bling\Responses\Prices\PricesCollectionResponse;
use Src\Users\Infrastructure\Laravel\Models\User;
use Throwable;

class SynchronizeFromMarketplace
{
    public function __construct(
        private BlingRepository $erpRepository,
        private CalculateProfit $calculateProfit,
        private GetCommission $getCommission,
        private PriceRepository $priceRepository
    ) {
    }

    public function sync(Marketplace $marketplace, int $page = 1): bool
    {
        $user = $marketplace->getUser();

        $prices = $this->erpRepository->allInMarketplace(
            $user->getErpToken(),
            $marketplace,
            Config::ACTIVE,
            $page
        );

        if (empty($prices->data())) {
            return false;
        }

        $this->save($prices, $user);

        return true;
    }

    public function save(PricesCollectionResponse $prices, User $user): void
    {
        foreach ($prices->data() as $price) {
            $priceModels = $this->priceRepository->getPriceFromMarketplace(
                $price->store, $price->store_sku_id, $price->product_sku, $user->getId()
            );

            $commission = $this->getCommission->getFromPrice($price, $user);
            $profit = $this->calculateProfit->fromModel($price, $user);

            if ($priceModels->count() === 0) {
                $this->priceRepository->insert($price, $commission, $profit, $user->getId());

                continue;
            }

            foreach ($priceModels as $priceModel) {
                $this->priceRepository->update($priceModel, $price->value, $profit, $commission);
            }
        }
    }
}
