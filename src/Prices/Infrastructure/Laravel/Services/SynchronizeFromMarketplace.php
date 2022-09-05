<?php

namespace Src\Prices\Infrastructure\Laravel\Services;

use Src\Math\MoneyTransformer;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Domain\Services\SynchronizeFromMarketplace as SynchronizeFromMarketplaceInterface;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Prices\Infrastructure\Laravel\Repositories\PricesRepository;
use Src\Products\Domain\Models\Product;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Products\Infrastructure\Bling\ProductRepository as BlingRepository;
use Src\Products\Infrastructure\Bling\Responses\Prices\PricesCollectionResponse;
use Src\Users\Infrastructure\Laravel\Models\User;

class SynchronizeFromMarketplace implements SynchronizeFromMarketplaceInterface
{
    public function __construct(
        private BlingRepository $erpRepository,
        private CommissionRepository $commissionRepository,
        private PricesRepository $priceRepository,
        private ProductRepository $productRepository
    ) {}

    public function sync(Marketplace $marketplace, int $page = 1, string $status = self::ACTIVE): bool
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

    private function save(PricesCollectionResponse $prices, User $user, Marketplace $marketplace): void
    {
        /**
         * @var Price $price
         */
        foreach ($prices->data() as $price) {
            $product = $this->productRepository->get($price->getProductSku(), $user->getId());

            if (!$product) {
                continue;
            }

            $commissionRate = $this->getCommissionRate($marketplace, $product);
            $profit = $this->getProfit($marketplace, $product, $price->getValue());
            $priceModel = $marketplace->getPrice($price->getProductSku());

            if (!$priceModel) {
                $this->priceRepository->insert($price, $product, $marketplace, $commissionRate, $profit);

                continue;
            }

            $this->priceRepository->update($priceModel, $price->getValue(), $profit, $commissionRate);
        }
    }

    private function getCommissionRate(Marketplace $marketplace, Product $product): float
    {
        return $this->commissionRepository->getCommissionRate($marketplace, $product)->get();
    }

    private function getProfit(Marketplace $marketplace, Product $product, float $value): float
    {
        $commission = $this->commissionRepository->get(
            $marketplace,
            $product,
            $value
        );

        $price = CalculatedPrice::fromProduct(
            $product,
            MoneyTransformer::toMoney($commission),
            new CalculatorForm(desiredPrice: $value)
        );

        return MoneyTransformer::toFloat($price->getProfit());
    }
}
