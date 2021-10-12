<?php

namespace Src\Products\Domain\Models;

use App\Exceptions\Store\InvalidStoreException;
use Src\Products\Application\Factories\Product as ProductFactory;
use Src\Products\Domain\Entities\Product as ProductEntity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\Prices\Domain\Price\Models\Price;

class Product extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'erp_id',
        'sku',
        'name',
        'brand',
        'purchase_price',
        'tax_icms',
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
    ];

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }

    public function compositionProducts(): array
    {
        foreach ($this->composition_products as $composition_product) {
            if (!$model = $this->find($composition_product)) {
                continue;
            }

            $composition[] = $model;
        }

        return $composition ?? [];
    }

    public function hasCompositionProducts(): bool
    {
        return !empty($this->composition_products);
    }

    public function inStore(string $store): bool
    {
        foreach ($this->prices ?? [] as $price) {
            if ($price->store === $store) {
                return true;
            }
        }

        return false;
    }

    public function isActive(): bool
    {
        $hasPrices = $this->prices()->count() > 0;

        return (bool) $this->is_active && $hasPrices;
    }


    public function getPrice(string $store): ?Price
    {
        foreach ($this->prices ?? [] as $price) {
            if ($price->store === $store) {
                return $price;
            }
        }

        return null;
    }

    public function profitMargin(string $store): float
    {
        if (!$price = $this->getPrice($store)) {
            throw new InvalidStoreException();
        }

        return $price->margin();
    }

    /**
     * @return Product[]
     */
    public function getVariations(): array
    {
        $products = $this->where('parent_sku', $this->id)->get()->all();

        return $products ?? [];
    }

    public function toDomainObject(): ProductEntity
    {
        return ProductFactory::buildFromModel($this);
    }
}
