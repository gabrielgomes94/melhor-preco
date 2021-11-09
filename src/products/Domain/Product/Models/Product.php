<?php

namespace Src\Products\Domain\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Prices\Price\Domain\Models\Price;
use Src\Products\Domain\Product\Contracts\Models\Product as ProductInterface;
use Src\Products\Domain\Product\Contracts\Models\Data\Product as ProductData;
use Src\Products\Domain\Product\Models\Data\Composition\Composition;
use Src\Products\Domain\Product\Models\Data\Costs\Costs;
use Src\Products\Domain\Product\Models\Data\Details\Details;
use Src\Products\Domain\Product\Models\Data\Dimensions\Dimensions;
use Src\Products\Domain\Product\Models\Data\Factory;
use Src\Products\Domain\Product\Models\Data\Variations\Variations;

class Product extends Model implements ProductInterface
{
    private const PER_PAGE = 15;

    private const PURCHASE_PRICE = 'purchase_price';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'erp_id',
        'sku',
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
    ];

    protected $primaryKey = 'sku';

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class, 'product_id', 'sku');
    }

    public function data(): ProductData
    {
        $data = Factory::make(
            array_merge($this->toArray(), [
                'prices' => $this->prices->toArray(),
                'parent_sku' => $this->parent_sku ?? '',
                'stock' => $this->stock ?? 0,
                'variations' => $this->getVariations(),
                'composition' => $this->getComposition(),
            ])
        );

        return $data;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function hasVariations(): bool
    {
        return $this->data()->hasVariations();
    }

    public function setActive(bool $status)
    {
        $this->is_active = $status;
    }

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

    public function setPosts()
    {

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
            if(!$compositionProducts = $this->where('sku', $product)->first()) {
                continue;
            }

            $compositionProducts[] = $compositionProducts->data();
        }

        return $compositionProducts ?? [];
    }

    // Mover essas lógicas pra Model de Prices
    public static function listCompositionProducts(string $storeSlug, int $page): LengthAwarePaginator
    {
        return self::leftJoin('prices', 'prices.product_id', '=', 'products.id')
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
        return self::leftJoin('prices', 'prices.product_id', '=', 'products.id')
            ->whereNull('parent_sku')
            ->where('is_active', true)
            ->where('prices.store', $storeSlug)
            ->orderBy('prices.updated_at', 'desc')
            ->paginate(perPage: self::PER_PAGE, page: $page);
    }

    public static function listProducts(string $storeSlug, int $page = 1)
    {
        return self::join('prices', 'prices.product_id', '=', 'products.id')
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
                $sku = '%"' . $sku .'"%';

                $query->where('composition_products', 'like', $sku)
                    ->where('store', $storeSlug)
                    ->where('is_active', true);
            })
            ->orderBy('product_id')
            ->paginate(perPage: self::PER_PAGE, page: $page);
    }
}
