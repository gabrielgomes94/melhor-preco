<?php

namespace Barrigudinha\Product;

use Barrigudinha\Pricing\Data\Price;
use Barrigudinha\Pricing\Data\Product as PricingProduct;
use Barrigudinha\Pricing\Data\Tax;
use Barrigudinha\Product\Data\Costs;
use Barrigudinha\Utils\Helpers;

class Product
{
    private ?string $erpId;
    private string $sku;
    private string $name;
    private string $brand;
    private int $stock;
    private float $purchasePrice;
    private ?float $additionalCosts = 0.0;
    private Dimensions $dimensions;
    private float $weight;
    private float $taxICMS;
    private ?string $parentSku;

    public ?Costs $costs;

    /** @var string[] */
    private array $images;

    /** @var Store[] array */
    public array $stores = [];

    /** @var Tax[] $taxes */
    public array $taxes;

    /** @var Post[] $posts */
    public array $posts = [];

    public function __construct(
        string $sku,
        string $name,
        string $brand,
        array $images,
        ?int $stock,
        float $purchasePrice,
        Dimensions $dimensions,
        float $weight,
        ?float $taxICMS,
        ?string $erpId,
        ?string $parentSku,
        ?float $additionalCosts = 0.0,
        ?Costs $costs = null
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->brand = $brand;
        $this->images = $images;
        $this->stock = (int) $stock ?? 0;
        $this->purchasePrice = $purchasePrice;
        $this->dimensions = $dimensions;
        $this->weight = $weight;
        $this->erpId = $erpId;

        $this->taxes[] = new Tax(Tax::ICMS, 'in', $taxICMS ?? 0.0);
        $this->taxICMS = $taxICMS ?? 0.0;
        $this->parentSku = $parentSku;
        $this->additionalCosts = $additionalCosts;

        $this->costs = $costs;
    }

    public function addPost(Post $post)
    {
        $this->posts[] = $post;
    }

    public function addStore(Store $storeInfo)
    {
        $this->stores[] = $storeInfo;
    }

    public function toPricing(): PricingProduct
    {
        return new PricingProduct([
            'name' => $this->name,
            'sku' => $this->sku,
            'purchase_price' => $this->purchasePrice ?? 0.0,
            'stores' => $this->stores,
            'depth' => $this->dimensions->depth(),
            'height' => $this->dimensions->height(),
            'width' => $this->dimensions->width(),
        ]);
    }

    public function costs(): Costs
    {
        return $this->costs;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function dimensions(): Dimensions
    {
        return $this->dimensions;
    }

    public function erpId(): ?string
    {
        return $this->erpId ?? null;
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function stores(): array
    {
        return $this->stores;
    }

    public function parentSku(): ?string
    {
        return $this->parentSku;
    }

    public function posts(): array
    {
        return $this->posts ?? [];
    }

    public function post(string $store): ?Post
    {
        foreach ($this->posts() as $post) {
            if ($post->store()->slug() === $store) {
                return $post;
            }
        }

        return null;
    }

    public function tax(string $taxCode): ?Tax
    {
        foreach ($this->taxes as $tax) {
            if ($taxCode === $tax->name) {
                return $tax;
            }
        }

        return null;
    }

    public function weight(): float
    {
        return $this->weight;
    }

    public function setCosts(Costs $costs): void
    {
        $this->costs = $costs;
    }
}
