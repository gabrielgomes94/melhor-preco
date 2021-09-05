<?php

namespace Barrigudinha\Pricing\Services;

use App\Repositories\Pricing\Product\Creator as ProductCreator;
use App\Repositories\Product\GetDB;
use Barrigudinha\Pricing\Data\Contracts\CreatePricing as CreatePricingData;
use Barrigudinha\Pricing\Data\Pricing;
use Barrigudinha\Pricing\Repositories\Contracts\Pricing as PricingRepository;
use Integrations\Bling\Products\Repositories\Repository;

/**
 * @deprecated
 * TO DO: mover essa classe para dentro do contexto Pricing/PriceList e renomear ela.
 */
class CreatePricing
{
    private PricingRepository $pricingRepository;
    private ProductCreator $productCreator;
    private Repository $productFinderBling;
    private GetDB $productFinderDB;

    public function __construct(
        ProductCreator $productCreator,
        Repository $productFinderBling,
        GetDB $productFinderDB,
        PricingRepository $pricingRepository
    ) {
        $this->productCreator = $productCreator;
        $this->productFinderBling = $productFinderBling;
        $this->productFinderDB = $productFinderDB;
        $this->pricingRepository = $pricingRepository;
    }

    public function create(CreatePricingData $data)
    {
        foreach ($data->skuList() as $sku) {
            if ($product = $this->productFinderDB->get($sku)) {
                $products[] = $product;

                continue;
            }
        }

        $pricing = new Pricing(
            name: $data->name(),
            products: $products ?? [],
            stores: $data->stores() ?? []
        );

        $this->pricingRepository->create($pricing);

        return $pricing;
    }
}
