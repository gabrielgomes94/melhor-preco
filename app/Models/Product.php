<?php

namespace App\Models;

use App\Factories\Product\Product as ProductFactory;
use App\Models\Product as ProductModel;
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
        'tax_ipi',
        'tax_icms',
        'tax_simples_nacional',
        'additional_costs',
        'depth',
        'height',
        'width',
        'weight',
        'parent_sku',
        'additional_costs',
        'has_variations',
    ];

    public function pricings(): BelongsToMany
    {
        return $this->belongsToMany(Pricing::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }

    public function inStore(string $store): bool
    {
        foreach ($this->prices as $price) {
            if ($price->store === $store) {
                return true;
            }
        }

        return false;
    }

    public function getPrice(string $store): ?Price
    {
        foreach ($this->prices as $price) {
            if ($price->store === $store) {
                return $price;
            }
        }

        return null;
    }

    /**
     * @return Product[]
     */
    public function getVariations(): array
    {
        $products = $this->where('parent_sku', $this->id)->get()->all();

        return $products ?? [];
    }

    public function toDomainObject(): \Barrigudinha\Product\Product
    {
        return ProductFactory::buildFromModel($this);
    }
}
