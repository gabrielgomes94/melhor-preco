<?php

namespace Src\Products\Domain\Models\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
use Src\Marketplaces\Application\Models\Marketplace;
use Src\Prices\Domain\Models\Price;
use Src\Products\Domain\Models\Categories\Category;
use Src\Products\Domain\Models\Product\Data\Composition\Composition;
use Src\Products\Domain\Models\Product\Data\Costs\Costs;
use Src\Products\Domain\Models\Product\Data\Details\Details;
use Src\Products\Domain\Models\Product\Data\Dimensions\Dimensions;
use Src\Products\Domain\Models\Product\Data\Identifiers\Identifiers;
use Src\Products\Domain\Models\Product\Data\Variations\Variations;
use Src\Products\Domain\Models\Product\Contracts\Product as ProductModelInterface;
use Src\Sales\Domain\Models\Item;

class Product extends Model implements ProductModelInterface
{
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
        'category_id',
        'quantity',
    ];

    protected $casts = [
        'composition_products' => 'array',
        'images' => 'array',
        'sku' => 'string',
    ];

    protected $primaryKey = 'sku';

    public $keyType = 'string';

    public $incrementing = false;

    public $escapeWhenCastingToString = true;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class, 'product_sku', 'sku');
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'sku', 'sku');
    }

    public function itemsCosts(): HasMany
    {
        return $this->hasMany(PurchaseItem::class, 'ean', 'ean');
    }

    public function getLatestPurchaseItem(): ?PurchaseItem
    {
        return $this->getPurchaseItem(Carbon::now());
    }

    public function getPurchaseItem(Carbon $date): ?PurchaseItem
    {
        $items = $this->itemsCosts;

        $items = $items->map(function ($item) use ($date) {
            $interval = $item->getIssuedAt()->diffInDays($date, false);

            return [
                'interval' => $interval,
                'model' => $item,
                'issuedAt' => (string) $item->getIssuedAt(),
            ];
        });

        $items = $items->filter(function ($item) {
            return $item['interval'] >= 0;
        });

        $minimumInterval = $items->min('interval');
        $item = $items->where('interval', $minimumInterval)->first()['model'] ?? null;

        return $item;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getSaleItems(): Collection
    {
        return $this->items;
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function getCategoryId(): string
    {
        return $this->getCategory()?->getCategoryId() ?? '';
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

    public function getPrices(): Collection
    {
        return $this->prices ?? collect();
    }

    public function getCreationDate(): Carbon
    {
        return $this->created_at;
    }

    public function getLastUpdate(): Carbon
    {
        return $this->updated_at;
    }

    public function hasCompositionProducts(): bool
    {
        return $this->getComposition()->hasCompositions();
    }

    public function isActive(): bool
    {
        return $this->is_active && $this->prices->count() > 0;
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

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWithSku($query, string $sku)
    {
        return $query->where('sku', $sku)
            ->orWhere(function ($query) use ($sku) {
                $query->where('parent_sku', $sku)
                    ->active();
            })
            ->orWhere(function ($query) use ($sku) {
                $sku = "%{$sku}%";

                $query->where('composition_products', 'like', $sku)
                    ->active();
            });
    }

    public function scopeInCategory($query, string $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeOrderBySku($query)
    {
        return $query->orderByRaw('CAST(sku AS INTEGER) DESC');
    }

    public function scopeIsOnStore($query, string $store)
    {

        return $query->whereHas('prices', function (Builder $query) use ($store) {
            $query->where('store', '=', $store);
        });
    }

    public function postedOnMarketplace(Marketplace $marketplace): bool
    {
        $slug = $marketplace->getSlug();
        $prices = $this->prices;

        foreach ($prices as $price) {
            if ($price->getMarketplace()->getSlug() === $slug) {
                return true;
            }
        }

        return false;
    }

    public function getImages(): array
    {
        return $this->images;
    }
}
