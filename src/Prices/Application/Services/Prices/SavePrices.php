<?php

namespace Src\Prices\Application\Services\Prices;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Src\Calculator\Application\Services\CalculateProfit;
use Src\Marketplaces\Domain\UseCases\Contracts\GetCommission;
use Src\Prices\Domain\Events\PriceSynchronized;
use Src\Prices\Domain\Events\PriceWasNotSynchronized;
use Src\Prices\Domain\Models\Price;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Infrastructure\Bling\Responses\Prices\PricesCollectionResponse;

class SavePrices
{
    private CalculateProfit $calculateProfit;
    private GetCommission $getCommission;

    public function __construct(
        CalculateProfit $calculateProfit,
        GetCommission $getCommission,
    ) {
        $this->calculateProfit = $calculateProfit;
        $this->getCommission = $getCommission;
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

                throw $error;
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
