<?php

namespace App\Models;

use App\Exceptions\Store\InvalidStoreException;
use App\Factories\Product\Product as ProductFactory;
use Barrigudinha\Product\Entities\Product as ProductEntity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'erp_id',
        'sku',
        'name',
        'purchase_price',
        'tax_icms',
        'additional_costs',
        'depth',
        'height',
        'width',
        'weight',
        'parent_sku',
        'additional_costs',
        'has_variations',
        'composition_products'
    ];

    protected $casts = [
        'composition_products' => 'array',
    ];

    public function pricings(): BelongsToMany
    {
        return $this->belongsToMany(Pricing::class);
    }

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
