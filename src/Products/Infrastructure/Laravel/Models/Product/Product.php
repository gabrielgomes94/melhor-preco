<?php

namespace Src\Products\Infrastructure\Laravel\Models\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Domain\Models\Product\Product as ProductModelInterface;
use Src\Products\Domain\Models\Product\ValueObjects\Composition;
use Src\Products\Domain\Models\Product\ValueObjects\Costs;
use Src\Products\Domain\Models\Product\ValueObjects\Dimensions;
use Src\Products\Domain\Models\Product\ValueObjects\Identifiers;
use Src\Products\Domain\Models\Product\ValueObjects\Variations;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Infrastructure\Laravel\Models\Product\Casts\CompositionCast;
use Src\Products\Infrastructure\Laravel\Models\Product\Casts\CostsCast;
use Src\Products\Infrastructure\Laravel\Models\Product\Casts\DimensionsCast;
use Src\Products\Infrastructure\Laravel\Models\Product\Casts\IdentifiersCast;
use Src\Products\Infrastructure\Laravel\Models\Product\Casts\VariationsCast;
use Src\Products\Infrastructure\Laravel\Models\Product\Traits\ProductScopes;
use Src\Sales\Infrastructure\Laravel\Models\Item;
use Src\Users\Infrastructure\Laravel\Models\User;

class Product extends Model implements ProductModelInterface
{
    use ProductScopes;

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
        'costs' => CostsCast::class,
        'dimensions' => DimensionsCast::class,
        'identifiers' => IdentifiersCast::class,
        'variations' => VariationsCast::class,
        'composition' => CompositionCast::class,
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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

    public function getName(): string
    {
        return $this->name;
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
        return $this->variations;
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
        return $this->costs;
    }

    public function getDimensions(): Dimensions
    {
        return $this->dimensions;
    }

    public function getPurchaseItemsCosts(): array
    {
        return $this->itemsCosts->all();
    }

    public function getLastPurchaseItemsCosts(): ?PurchaseItem
    {
        $items = collect($this->getPurchaseItemsCosts());

        return $items->sortByDesc(
            fn (PurchaseItem $item) => $item->getIssuedAt()
        )->first();
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

    public function postedOnMarketplace(Marketplace $marketplace): bool
    {
        $slug = $marketplace->getSlug();
        $prices = $this->prices;

        foreach ($prices as $price) {
            if ($price->getMarketplace()?->getSlug() == $slug) {
                return true;
            }
        }

        return false;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function getUser(): \Src\Users\Domain\Models\User
    {
        return $this->user;
    }


    public function getUserId(): string
    {
        return $this->getUser()->getId();
    }

    public function getPrice(Marketplace $marketplace): ?Price
    {
        $slug = $marketplace->getSlug();
        $prices = $this->prices;

        foreach ($prices as $price) {
            if ($price->getMarketplace()?->getSlug() == $slug) {
                return $price;
            }
        }

        return null;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getCubicWeight(): float
    {
        return $this->getDimensions()->cubicWeight();
    }

    public function setCosts(Costs $costs): void
    {
        $this->costs = $costs;
    }
}
