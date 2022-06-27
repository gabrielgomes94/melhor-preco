<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Prices;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Src\Calculator\Application\Services\CalculateProfit;
use Src\Integrations\Bling\Products\Requests\Config;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Marketplaces\Domain\UseCases\Contracts\GetCommission;
use Src\Prices\Domain\Events\PriceSynchronized;
use Src\Prices\Domain\Events\PriceWasNotSynchronized;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Infrastructure\Bling\ProductRepository as BlingRepository;
use Src\Products\Infrastructure\Bling\Responses\Prices\PricesCollectionResponse;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class SynchronizeFromMarketplace
{
    public function __construct(
        private BlingRepository $erpRepository,
        private CalculateProfit $calculateProfit,
        private GetCommission $getCommission
    ) {
    }

    public function sync(Marketplace $marketplace, string $erpToken, int $page = 1): bool
    {
        $prices = $this->erpRepository->allInMarketplace(
            $erpToken,
            $marketplace,
            Config::ACTIVE,
            $page
        );

        if (empty($prices->data())) {
            return false;
        }

        $this->save($prices);

        return true;
    }

    public function save(PricesCollectionResponse $prices): void
    {
        foreach ($prices->data() as $price) {
            try {
                $priceModels = $this->getPrices($price);
                if ($priceModels->count() === 0) {
                    $this->insertPrice($price);

                    continue;
                }

                foreach ($priceModels as $priceModel) {
                    $this->updatePrice($priceModel, $price->value);
                }
            } catch (\Throwable $error) {
                $this->logErrors($error->getMessage(), $price->toArray());

                continue;
            }
        }
    }

    private function getPrices(Price $price): Collection
    {
        return Price::where('store', $price->store)
            ->where('store_sku_id', $price->store_sku_id)
            ->where('product_sku', $price->product_sku)
            ->get();
    }

    private function insertPrice(Price $price): void
    {
        $product = Product::where('sku', $price->product_sku)->get()->first();
        $price = $this->updateCommissionAndProfit($price);
        $price->product()->associate($product);
        $price->user_id = $price->getMarketplace()->user_id;

        $this->savePrice($price);
    }

    private function logErrors(string $message, array $price): void
    {
        Log::info('[Price]: Erro na sincronização de preços', [
            'error' => $message,
            'price' => $price,
        ]);
    }

    private function savePrice(Price $price)
    {
        $price->save()
            ? event(new PriceSynchronized($price))
            : event(new PriceWasNotSynchronized($price));
    }

    private function updatePrice(Price $price, float $value): void
    {
        $price->value = $value;
        $price = $this->updateCommissionAndProfit($price);

        $this->savePrice($price);
    }

    private function updateCommissionAndProfit(Price $price): Price
    {
        $commission = $this->getCommission->get(
            $price->getMarketplaceErpId(),
            $price->getProductSku()
        );
        $profit = $this->calculateProfit->fromModel($price);

        $price->fill([
            'commission' => $commission,
            'profit' => $profit,
        ]);

        return $price;
    }
}
