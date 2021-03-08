<?php

namespace App\Casts\Pricing;

use Barrigudinha\Pricing\Data\Product;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class ProductIterator implements CastsAttributes
{
    /**
     * Transform the attribute from the underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        $products = json_decode($value);

        $productList = [];
        foreach ($products as $product) {
            $productList[] = new Product(
                $product->sku,
                $product->stock,
                $product->purchasePrice
            );
        }

        return collect($productList);
    }

    /**
     * Transform the attribute to its underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if (! $value instanceof Collection) {
            throw new InvalidArgumentException('The given value is not an Collection instance.');
        }

        $products = $value->map(function ($product) {
            return $product;
        });

        return $products->toArray();
    }
}
