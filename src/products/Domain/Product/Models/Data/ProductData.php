<?php

namespace Src\Products\Domain\Product\Models\Data;

use Src\Products\Domain\Post\Post;
use Src\Products\Domain\Product\Contracts\Models\Data\Composition\Composition;
use Src\Products\Domain\Product\Contracts\Models\Data\Costs\Costs;
use Src\Products\Domain\Product\Contracts\Models\Data\Details\Details;
use Src\Products\Domain\Product\Contracts\Models\Data\Dimensions\Dimensions;
use Src\Products\Domain\Product\Contracts\Models\Data\Identifiers\Identifiers;
use Src\Products\Domain\Product\Contracts\Models\Data\Product as ProductInterface;
use Src\Products\Domain\Product\Contracts\Models\Data\Variations\Variations;
use Src\Products\Domain\Store\Store;

class ProductData implements ProductInterface
{
    private ?int $stock;

    private Identifiers $identifiers;

    private Details $details;

    private Composition $composition;

    private Costs $costs;

    private Dimensions $dimensions;

    private Variations $variations; // Variation, HasVariations, NoVariations, BaseVariation

    private bool $isActive;

    private array $posts;

    public function __construct(
        Identifiers $identifiers,
        Costs $costs,
        Details $details,
        Dimensions $dimensions,
        Variations $variations,
        Composition $composition,
        array $posts,
        bool $isActive,
        ?int $stock,
    ) {
        $this->identifiers = $identifiers;
        $this->details = $details;
        $this->dimensions = $dimensions;
        $this->costs = $costs;
        $this->variations = $variations;
        $this->composition = $composition;
        $this->posts = $posts;
        $this->isActive = $isActive;
        $this->stock = $stock;
    }

    public function getIdentifiers(): Identifiers
    {
        return $this->identifiers;
    }

    public function getComposition(): Composition
    {
        return $this->composition;
    }

    public function getCosts(): Costs
    {
        return $this->costs;
    }

    public function getDetails(): Details
    {
        return $this->details;
    }

    public function getDimensions(): Dimensions
    {
        return $this->dimensions;
    }

    public function getPost(string $storeSlug): ?Post
    {
        foreach ($this->posts as $post) {
            if ($post->getStore()->getSlug() === $storeSlug) {
                return $post;
            }
        }

        return null;
    }

    public function getPosts(): array
    {
        return $this->posts;
    }

    public function getSku(): string
    {
        return $this->identifiers->getSku();
    }

    public function getStore(string $storeSlug): ?Store
    {
        foreach ($this->posts as $post) {
            if ($post->getStore()->getSlug() === $storeSlug) {
                return $post->getStore();
            }
        }

        return null;
    }

    public function getStores(): array
    {
        // TODO: Implement getStores() method.
    }

    public function getVariations(): ?Variations
    {
        return $this->variations;
    }

    public function hasCompositionProducts(): bool
    {
        return $this->composition->hasCompositions();
    }

    public function hasVariations(): bool
    {
        return (bool) count($this->variations->get());
    }

    public function isActive(): bool
    {
        return $this->isActive && count($this->posts) > 0;
    }

    public function toArray(): array
    {
        return [

        ];
    }
}
