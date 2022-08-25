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
use Src\Products\Domain\Models\Product as ProductModelInterface;
use Src\Products\Domain\Models\ValueObjects\Composition;
use Src\Products\Domain\Models\ValueObjects\Costs;
use Src\Products\Domain\Models\ValueObjects\Dimensions;
use Src\Products\Domain\Models\ValueObjects\Identifiers;
use Src\Products\Domain\Models\ValueObjects\Variations;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Infrastructure\Laravel\Models\Product\Casts\CompositionCast;
use Src\Products\Infrastructure\Laravel\Models\Product\Casts\CostsCast;
use Src\Products\Infrastructure\Laravel\Models\Product\Casts\DimensionsCast;
use Src\Products\Infrastructure\Laravel\Models\Product\Casts\IdentifiersCast;
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

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function getCategoryId(): string
    {
        return $this->getCategory()?->getCategoryId() ?? '';
    }

    public function getComposition(): Composition
    {
        return $this->composition;
    }

    public function getCosts(): Costs
    {
        return $this->costs;
    }

    public function getCreationDate(): Carbon
    {
        return $this->created_at;
    }

    public function getCubicWeight(): float
    {
        return round($this->getDimensions()->cubicWeight(), 3);
    }

    public function getDimensions(): Dimensions
    {
        return $this->dimensions;
    }

    public function getEan(): string
    {
        return $this->ean;
    }

    public function getErpId(): string
    {
        return $this->erp_id;
    }

    public function getIdentifiers(): Identifiers
    {
        return $this->identifiers;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function getLastPurchaseItemsCosts(): ?PurchaseItem
    {
        $items = collect($this->getPurchaseItemsCosts());

        return $items->sortByDesc(
            fn (PurchaseItem $item) => $item->getIssuedAt()
        )->first();
    }

    public function getLastUpdate(): Carbon
    {
        return $this->updated_at;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParentSku(): ?string
    {
        return $this->parent_sku;
    }

    public function getPrices(): Collection
    {
        return $this->prices ?? collect();
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

    public function getPurchaseItemsCosts(): array
    {
        return $this->itemsCosts->all();
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getSaleItems(): Collection
    {
        return $this->items;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getUserId(): string
    {
        return $this->getUser()->getId();
    }

    public function getVariations(): Variations
    {
        $variationModels = $this->withParentSku($this->getSku())->get();

        return new Variations(
            $this->getSku(),
            $variationModels->all()
        );
    }

    public function hasCompositionProducts(): bool
    {
        return $this->getComposition()->hasCompositions();
    }

    public function hasVariations(): bool
    {
        return (bool) count($this->getVariations()->get());
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function isVariation(): bool
    {
        return (bool) $this->parent_sku;
    }

    public function setCosts(Costs $costs): void
    {
        $this->costs = $costs;
    }
}
