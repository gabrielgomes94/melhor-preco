<?php

namespace Barrigudinha\Pricing\Services;

use Barrigudinha\Pricing\Data\Contracts\CreatePricing as CreatePricingData;
use Barrigudinha\Pricing\Data\Pricing;
use Barrigudinha\Pricing\Data\Product as PricingProduct;
use Barrigudinha\Pricing\Repositories\Contracts\Pricing as PricingRepository;
use Barrigudinha\Product\Repositories\Product as ProductRepository;

class CreatePricing
{
    private PricingRepository $pricingRepository;
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository, PricingRepository $pricingRepository)
    {
        $this->productRepository = $productRepository;
        $this->pricingRepository = $pricingRepository;
    }

    public function create(CreatePricingData $data)
    {
        foreach($data->skuList() as $sku) {
            if (!$product = $this->productRepository->get($sku)) {
                continue;
            }

            $products[] = new PricingProduct($product);
        }

        $pricing = new Pricing($data->name(), $products, $data->stores() ?? []);
        $this->pricingRepository->create($pricing);

        return $pricing;
    }
}