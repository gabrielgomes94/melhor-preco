<?php

namespace Src\Prices\Application\UseCases;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Src\Calculator\Application\Services\CalculateProfit;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Domain\UseCases\Contracts\GetCommission;
use Src\Prices\Domain\Events\PriceSynchronized;
use Src\Prices\Domain\Events\PriceWasNotSynchronized;
use Src\Prices\Domain\Models\Price;
use Src\Prices\Domain\UseCases\Contracts\SynchronizePrices as SynchronizePricesInterface;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Infrastructure\Bling\ProductRepository as BlingRepository;
use TypeError;

use function event;

class SynchronizePrices implements SynchronizePricesInterface
{
    private BlingRepository $erpRepository;
    private CalculateProfit $calculateProfit;
    private GetCommission $getCommission;
    private MarketplaceRepository $marketplaceRepository;

    public function __construct(
        BlingRepository $erpRepository,
        CalculateProfit $calculateProfit,
        GetCommission $getCommission,
        MarketplaceRepository $marketplaceRepository
    ) {
        $this->erpRepository = $erpRepository;
        $this->calculateProfit = $calculateProfit;
        $this->getCommission = $getCommission;
        $this->marketplaceRepository = $marketplaceRepository;
    }

    public function syncAll(): void
    {
        $marketplaces = $this->marketplaceRepository->list();

        foreach ($marketplaces as $marketplace) {
            $this->sync($marketplace);
        }
    }

    public function syncMarketplace(string $marketplaceSlug): void
    {
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug);
        $this->sync($marketplace);
    }

    private function sync(Marketplace $marketplace): void
    {
        $prices = $this->erpRepository->allOnStore($marketplace);
        $this->savePrices($prices);
    }

    private function insertPrice(Price $price): void
    {
        $product = Product::where('sku', $price->product_sku)->get()->first();
        $price = $this->updateCommissionAndProfit($price);
        $price->product()->associate($product);

        $this->savePrice($price);
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

    private function getPrices(Price $price): Collection
    {
        return Price::where('store', $price->store)
            ->where('store_sku_id', $price->store_sku_id)
            ->where('product_sku', $price->product_sku)
            ->get();
    }

    private function logErrors(string $message, array $price): void
    {
        Log::info('[Price]: Erro na sincronização de preços', [
            'error' => $message,
            'price' => $price,
        ]);
    }

    private function savePrices(array $prices): void
    {
        foreach ($prices as $price) {
            try {
                $priceModels = $this->getPrices($price);
                if ($priceModels->count() === 0) {
                    $this->insertPrice($price);

                    continue;
                }

                foreach ($priceModels as $priceModel) {
                    $this->updatePrice($priceModel, $price->value);
                }
            } catch (ProductNotFoundException $exception) {
                $this->logErrors($exception->getMessage(), $price->toArray());

                continue;
            } catch (\Exception $exception) {
                $this->logErrors($exception->getMessage(), $price->toArray());

                continue;
            } catch (TypeError $error) {
                $this->logErrors($error->getMessage(), $price->toArray());

                continue;
            }
        }
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
