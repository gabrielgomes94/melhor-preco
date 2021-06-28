<?php

namespace Barrigudinha\Product;

use Barrigudinha\Pricing\Data\Price;
use Barrigudinha\Pricing\Data\Product as PricingProduct;
use Barrigudinha\Pricing\Data\Tax;
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
    }

    // TODO: adicionar preços ao criar objeto
    public static function createFromArray(array $data, array $stores = []): self
    {
        $dimensions = new Dimensions(
            depth: $data['dimensions']['depth'] ?? 0.0,
            height: $data['dimensions']['height'] ?? 0.0,
            width: $data['dimensions']['width'] ?? 0.0
        );

        $product = new self(
            sku: $data['sku'],
            name: $data['name'],
            brand: $data['brand'] ?? '',
            images: $data['images'] ?? [],
            stock: $data['stock'] ?? 0,
            purchasePrice: $data['purchasePrice'] ?? 0.0,
            dimensions: $dimensions,
            weight: $data['weight'] ?? 0.0,
            taxICMS: $data['tax_icms'] ?? null,
            erpId: null
        );


        if (isset($data['store'])) {
            $product->stores[] = Store::createFromArray($data['store']);
        } elseif (isset($stores)) {
            foreach ($stores as $store) {
                $product->stores[] = Store::createFromArray($store);
            }
        }

        return $product;
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

    public function additionalCosts(): float
    {
        return $this->additionalCosts;
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

    public function purchasePrice(): float
    {
        return $this->purchasePrice;
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function stores(): array
    {
        return $this->stores;
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
}
