<?php

namespace Src\Products\Domain\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Costs\Domain\Models\PurchaseItems;
use Src\Prices\Price\Domain\Models\Price;
use Src\Products\Domain\Models\Post\Factories\Factory as PostFactory;
use Src\Products\Domain\Models\Product\Data\Composition\Composition;
use Src\Products\Domain\Models\Product\Data\Costs\Costs;
use Src\Products\Domain\Models\Product\Data\Details\Details;
use Src\Products\Domain\Models\Product\Data\Dimensions\Dimensions;
use Src\Products\Domain\Models\Product\Data\Identifiers\Identifiers;
use Src\Products\Domain\Models\Product\Data\Variations\Variations;
use Src\Products\Domain\Models\Product\Contracts\Product as ProductModelInterface;
use Src\Products\Domain\Models\Store\Contracts\Store;
use Src\Products\Domain\Models\Post\Post;
use Src\Sales\Domain\Models\Item;

class Product extends Model implements ProductModelInterface
{
    private const PER_PAGE = 15;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'erp_id',
        'sku',
        'ean',
        'name',
        'brand',
        'purchase_price',
        'tax_icms',
        'images',
        'additional_costs',
        'depth',
        'height',
        'width',
        'weight',
        'parent_sku',
        'has_variations',
        'composition_products',
        'is_active',
    ];

    protected $casts = [
        'composition_products' => 'array',
        'images' => 'array',
        'sku' => 'string',
    ];

    protected $primaryKey = 'sku';

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class, 'product_id', 'sku');
    }

    public function items(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'product_id', 'sku');
    }

    public function itemsCosts(): HasMany
    {
        return $this->hasMany(PurchaseItems::class, 'ean', 'ean');
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getIdentifiers(): Identifiers
    {
        return new Identifiers($this->sku, $this->erp_id);
    }

    public function getComposition(): Composition
    {
        foreach ($this->composition_products as $product) {
            if (!$compositionProduct = $this->where('sku', $product)->first()) {
                continue;
            }

            $compositionProducts[] = $compositionProduct;
        }

        return new Composition($compositionProducts ?? []);
    }

    public function hasVariations(): bool
    {
        return (bool) count($this->getVariations()->get());
    }

    public function getVariations(): ?Variations
    {
        $variationModels = $this->where('parent_sku', $this->sku)->get();

        foreach ($variationModels as $variation) {
            $variationProducts[] = $variation->first();
        }

        return new Variations($this->parent_sku, $variationProducts ?? []);
    }

    public function getCosts(): Costs
    {
        return new Costs(
            purchasePrice: $this->purchase_price ?? 0.0,
            additionalCosts: $this->additional_costs ?? 0.0,
            taxICMS: $this->tax_icms ?? 0.0
        );
    }

    public function getDetails(): Details
    {
        return new Details(
            name: $this->name,
            brand: $this->brand ?? '',
            images: $this->images ?? []
        );
    }

    public function getDimensions(): Dimensions
    {
        return new Dimensions(
            $this->depth,
            $this->height,
            $this->width,
            $this->weight
        );
    }

    public function getPost(string $storeSlug): ?Post
    {
        foreach ($this->getPosts() as $post) {
            if ($post->getStore()->getSlug() === $storeSlug) {
                return $post;
            }
        }

        return null;
    }

    public function getPosts(): array
    {
        foreach ($this->prices->toArray() as $price) {
            $posts[] = PostFactory::make(array_merge($price, [
                'costs' => $this->getCosts(),
                'dimensions' => $this->getDimensions(),
            ]));
        }

        return $posts ?? [];
    }

    public function getStore(string $storeSlug): ?Store
    {
        foreach ($this->getPosts() as $post) {
            if ($post->getStore()->getSlug() === $storeSlug) {
                return $post->getStore();
            }
        }

        return null;
    }

    public function hasCompositionProducts(): bool
    {
        return $this->getComposition()->hasCompositions();
    }

    public function isActive(): bool
    {
        return $this->is_active && count($this->getPosts()) > 0;
    }

    public function setActive(bool $status)
    {
        $this->is_active = $status;
    }

    // @deprecated
    public function setDetails(Details $details)
    {
        $this->name = $details->getName();
        $this->brand = $details->getBrand();
    }

    public function setCosts(Costs $costs)
    {
        $this->purchase_price = $costs->purchasePrice();
        $this->tax_icms = $costs->taxICMS();
        $this->additional_costs = $costs->additionalCosts();
    }

    public function setCompositionProducts(Composition $composition)
    {
        $this->composition_products = $composition->getSkus();
    }

    public function setDimensions(Dimensions $dimensions)
    {
        $this->depth = $dimensions->depth();
        $this->height = $dimensions->height();
        $this->width = $dimensions->width();
        $this->weight = $dimensions->weight();
    }

    public function setVariations(Variations $variations)
    {
        $this->parent_sku = $variations->getParentSku();
        $this->has_variations = $this->hasVariations();
    }

    // Mover essas lógicas pra Model de Prices
    public static function listCompositionProducts(string $storeSlug, int $page): LengthAwarePaginator
    {
        return self::leftJoin('prices', 'prices.product_id', '=', 'products.sku')
            ->whereNull('parent_sku')
            ->where('is_active', true)
            ->whereNotNull('product_id')
            ->whereNotIn('composition_products', ['[]'])
            ->where('store', $storeSlug)
            ->orderBy('product_id')
            ->paginate(perPage: self::PER_PAGE, page: $page);
    }

    public static function listPricesLog(string $storeSlug, int $page = 1): LengthAwarePaginator
    {
        return self::leftJoin('prices', 'prices.product_id', '=', 'products.sku')
            ->whereNull('parent_sku')
            ->where('is_active', true)
            ->where('prices.store', $storeSlug)
            ->orderBy('prices.updated_at', 'desc')
            ->paginate(perPage: self::PER_PAGE, page: $page);
    }

    public static function listProducts(string $storeSlug, int $page = 1)
    {
        return self::leftJoin('prices', 'prices.product_id', '=', 'products.id')
            ->whereNull('parent_sku')
            ->where('is_active', true)
            ->whereNotNull('product_id')
            ->where('store', $storeSlug)
            ->orderBy('product_id')
            ->paginate(perPage: self::PER_PAGE, page: $page);
    }

    public static function listProductsBySku(string $storeSlug, string $sku, int $page = 1)
    {
        return self::leftJoin('prices', 'prices.product_id', '=', 'products.id')
            ->where('store', $storeSlug)
            ->where('sku', $sku)
            ->where('is_active', true)
            ->orWhere(function ($query) use ($sku, $storeSlug) {
                $query->where('parent_sku', $sku)
                    ->where('store', $storeSlug)
                    ->where('is_active', true);
            })
            ->orWhere(function ($query) use ($sku, $storeSlug) {
                $sku = '%"' . $sku . '"%';

                $query->where('composition_products', 'like', $sku)
                    ->where('store', $storeSlug)
                    ->where('is_active', true);
            })
            ->orderBy('product_id')
            ->paginate(perPage: self::PER_PAGE, page: $page);
    }
}
