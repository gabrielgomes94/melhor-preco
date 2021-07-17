<?php

namespace App\Presenters\Pricing\Product;

use Barrigudinha\Product\Product as ProductData;
use Barrigudinha\Pricing\Data\Tax;
use Barrigudinha\Product\Store;
use Barrigudinha\Product\Variations\Variations;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;

class Product
{
    private string $id;
    private string $name;
    private string $sku;
    private float $purchasePrice;
//    private float $taxIPI;
    private float $taxICMS;
//    private float $taxSimplesNacional;
    private float $additionalCosts;
    private array $prices;
    private ProductData $product;
    private $store;

    private DecimalMoneyFormatter $moneyFormatter;

    public function __construct(ProductData $product, ?string $store = null)
    {
        $this->id = $product->sku();
        $this->name = $product->name();
        $this->sku = $product->sku();
        $this->purchasePrice = $product->costs()->purchasePrice();
        $this->taxICMS = (float) $product->costs()->taxICMS();
        $this->additionalCosts = $product->costs()->additionalCosts();

        $this->product = $product;
        $this->store = $store;

        $this->moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
    }

    public function sku(): string
    {
        return $this->product->sku();
    }

    public function name(): string
    {
        return $this->product->name();
    }

    public function price(?string $store = null): string
    {
        $post = $this->product->post($store ?? $this->store);

        if (!$post) {
            return '';
        }

        $price = $this->moneyFormatter->format($post->price());

        return $price;
    }

    public function profit(?string $store = null): string
    {
        $post = $this->product->post($store ?? $this->store);

        if (!$post) {
            return '';
        }

        return $this->moneyFormatter->format($post->profit());
    }

    public function margin(?string $store = null): string
    {
        $post = $this->product->post($store ?? $this->store);

        if (!$post) {
            return '';
        }

        if ($post->price()->isZero()) {
            return '0.0';
        }

        $margin = $post->profit()->ratioOf($post->price()) * 100;

        return round($margin, 2);
    }

    public function purchasePrice(): string
    {
        $purchasePrice = $this->product->costs()->purchasePrice();

        return $purchasePrice;
    }

    public function taxICMS(): string
    {
        return $this->product->costs()->purchasePrice();
    }

    public function additionalCosts(): string
    {
        return $this->product->costs()->additionalCosts();
    }

    public function hasVariations(): bool
    {
        return $this->product->hasVariations();
    }

    /**
     * @return Product[]
     */
    public function variations(): array
    {
        $variations = $this->product->variations()->get();

        foreach ($variations as $variation) {
            $variationsPresented[] = new self($variation, $this->store);
        }

        return $variationsPresented ?? [];
    }
}
