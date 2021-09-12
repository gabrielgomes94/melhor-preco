<?php

namespace Barrigudinha\Product\Entities;

use Barrigudinha\Product\Data\Compositions\Composition;
use Barrigudinha\Product\Data\Costs;
use Barrigudinha\Product\Data\Dimensions;
use Barrigudinha\Product\Data\Store;
use Barrigudinha\Product\Data\Variations\Variations;

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

    public function brand(): string
    {
        return $this->brand;
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

    public function images(): array
    {
        return $this->images;
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

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function setDimensions(Dimensions $dimensions): void
    {
        $this->dimensions = $dimensions;
    }

    public function setImages(array $images): void
    {
        $this->images = $images;
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
        foreach ($posts as $post) {
            if ($post instanceof Post) {
                $updatedPosts[] = $post;
            }
        }

        $this->posts = $updatedPosts ?? [];
    }

    public function variations(): ?Variations
    {
        return $this->variations;
    }
}
