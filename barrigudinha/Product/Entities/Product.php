<?php

namespace Barrigudinha\Product\Entities;

use Barrigudinha\Pricing\Price\Price;
use Barrigudinha\Pricing\Data\Product as PricingProduct;
use Barrigudinha\Pricing\Data\Tax;
use Barrigudinha\Product\Data\Compositions\Composition;
use Barrigudinha\Product\Data\Costs;
use Barrigudinha\Product\Data\Dimensions;
use Barrigudinha\Product\Data\Store;
use Barrigudinha\Product\Data\Variations\Variations;
use Barrigudinha\Product\Entities\Post;
use Barrigudinha\Utils\Helpers;

class Product
{
    private ?string $erpId;
    private string $sku;
    private string $name;
    private string $brand;
    private int $stock;
    private ?float $additionalCosts = 0.0;
    private Dimensions $dimensions;
    private float $taxICMS;
    private ?string $parentSku;// To Do: talvez seja interessante mover o parentSku para dentro de Variations
    private bool $hasVariations;
    private ?Variations $variations; // Variation, HasVariations, NoVariations, BaseVariation
    private Composition $compositionProducts;
    private bool $isActive;

    public ?Costs $costs;

    /** @var string[] */
    private array $images;

    /** @var Store[] array */
    public array $stores = [];

    /** @var Tax[] $taxes */
    public array $taxes;

    /** @var Post[] $posts */
    public array $posts = [];

    /**
     * @param Composition[]|null $compositionProducts
     */
    public function __construct(
        string $sku,
        string $name,
        string $brand,
        array $images,
        bool $hasVariations,
        bool $isActive,
        ?int $stock,
        Dimensions $dimensions,
        ?float $taxICMS,
        ?string $erpId,
        ?string $parentSku,
        ?float $additionalCosts = 0.0,
        ?Costs $costs = null,
        ?Variations $variations = null,
        ?Composition $compositionProducts = null
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->brand = $brand;
        $this->images = $images;
        $this->stock = (int) $stock ?? 0;
        $this->dimensions = $dimensions;
        $this->erpId = $erpId;

        // To Do: remove this line
        $this->taxes[] = new Tax(Tax::ICMS, 'in', $taxICMS ?? 0.0);
        $this->taxICMS = $taxICMS ?? 0.0;
        $this->parentSku = $parentSku;
        $this->additionalCosts = $additionalCosts;

        $this->hasVariations = $hasVariations;
        $this->variations = $variations;

        $this->costs = $costs;
        $this->compositionProducts = $compositionProducts;
        $this->isActive = $isActive;
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

    public function compositionProducts(): array
    {
        return $this->compositionProducts->getSkus();
    }

    public function composition(): Composition
    {
        return $this->compositionProducts;
    }

    public function costs(): Costs
    {
        if ($this->hasCompositionProducts()) {
            return $this->composition()->costs();
        }

        return $this->costs;
    }

    public function isActive(): bool
    {
        return $this->isActive && count($this->posts) > 0;
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

    public function hasVariations(): bool
    {
        return $this->hasVariations;
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

    /**
     * @deprecated
     */
    public function post(string $store): ?Post
    {
        foreach ($this->posts() as $post) {
            if ($post->store()->slug() === $store) {
                return $post;
            }
        }

        return null;
    }

    public function getPost(string $storeSlug): ?Post
    {
        foreach ($this->posts() as $post) {
            if ($post->store()->slug() === $storeSlug) {
                return $post;
            }
        }

        return null;
    }

    public function getStore(string $storeSlug): ?Store
    {
        foreach ($this->stores() as $store) {
            if ($store->slug() === $storeSlug) {
                return $store;
            }
        }

        return null;
    }

    /**
     * @return Store[]
     */
    public function getStores(array $storesSlug): array
    {
        foreach ($storesSlug as $slug) {
            $stores[] = $this->getStore($slug);
        }

        return $stores ?? [];
    }

    public function hasCompositionProducts(): bool
    {
        return $this->compositionProducts->hasCompositions();
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

    public function setActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function setCompositionProducts(Composition $compositionProducts): void
    {
        $this->compositionProducts = $compositionProducts;
    }

    public function setCosts(Costs $costs): void
    {
        $this->costs = $costs;

        if ($this->hasVariations()) {
            foreach ($this->variations->get() as $variation) {
                $variation->setCosts($costs);
            }
        }
    }

    public function setDimensions(Dimensions $dimensions)
    {
        $this->dimensions = $dimensions;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @var Post[]
     */
    public function setPosts(array $posts): void
    {
        $updatedPosts = [];

        foreach ($posts as $post) {
            if (!$posts instanceof Post) {
                continue;
            }

            $updatedPosts[] = $post;
        }

        $this->posts = $updatedPosts ?? [];
    }

    public function variations(): ?Variations
    {
        return $this->variations;
    }
}
