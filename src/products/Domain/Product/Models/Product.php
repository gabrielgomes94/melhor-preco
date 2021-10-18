<?php

namespace Src\Products\Domain\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\Prices\Price\Domain\Models\Price;
use Src\Products\Domain\Product\Contracts\Models\Product as ProductInterface;
use Src\Products\Domain\Product\Contracts\Models\Data\Product as ProductData;
use Src\Products\Domain\Product\Models\Data\Factory;

class Product extends Model implements ProductInterface
{
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

    public function data(): ProductData
    {
        return Factory::make(
            array_merge($this->toArray(), [
                'prices' => $this->prices->toArray(),
                'parent_sku' => $this->parent_sku ?? '',
                'stock' => $this->stock ?? 0,
                'variations' => $this->getVariations(),
                'composition' => $this->getComposition(),
            ])
        );
    }

    private function getVariations(): array
    {
        $variations = $this->where('parent_sku', $this->sku)->get();

        foreach ($variations as $variation) {
            $variationProduct[] = $variation->first()->data();
        }

        return $variationProduct ?? [];
    }

    /**
     * @return ProductData[]
     */
    private function getComposition(): array
    {
        foreach ($this->composition_products as $product) {
            $compositionProducts[] = $this->where('sku', $product)->first()->data();
        }

        return $compositionProducts ?? [];
    }
}
