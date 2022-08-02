<?php

namespace Tests\Data\Models\Products;

use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Prices\PriceData;

class ProductData
{
    public static function make(array $data = []): Product
    {
        $data = self::getData($data);

        return new Product($data);
    }

    public static function makePersisted(User $user, array $data = []): Product
    {
        $data = self::getData($data);
        $product = new Product($data);
        $product->user_id = $user->id;
        $product->save();

        return $product->refresh();
    }

    public static function babyCarriage(User $user, array $prices = [], ?Category $category = null): Product
    {
        return self::persisted(
            $user,
            [
                'sku' => '1234',
                'name' => 'Carrinho de Bebê',
                'ean' => '7908238800092',
                'purchase_price' => 449.90,
            ],
            $prices,
            $category,
        );
    }

    public static function babyChair(User $user, array $prices = [], ?Category $category = null): Product
    {
        return self::persisted(
            $user,
            [
                'sku' => '987',
                'name' => 'Cadeirinha para Carros',
                'ean' => '7898089228339',
            ],
            $prices,
            $category
        );
    }

    public static function babyPacifier(User $user, array $prices = [], ?Category $category = null): Product
    {
        return self::persisted(
            $user,
            [
                'sku' => '777',
                'name' => 'Chupeta',
                'ean' => '7908103726649',
                'purchase_price' => 6.75,
            ],
            $prices,
            $category
        );
    }

    public static function blanket(User $user, array $prices = [], ?Category $category = null): Product
    {
        return self::persisted(
            $user,
            [
                'sku' => '821',
                'name' => 'Cobertor',
                'ean' => '7897905260881',
            ],
            $prices,
            $category
        );
    }

    public static function redBlanket(User $user, array $prices = [], ?Category $category = null): Product
    {
        return self::persisted(
            $user,
            [
                'sku' => '822',
                'parent_sku' => '821',
                'name' => 'Cobertor Vermelho',
                'ean' => '7897905260881',
            ],
            $prices,
            $category
        );
    }

    public static function blueBlanket(User $user, array $prices = [], ?Category $category = null): Product
    {
        return self::persisted(
            $user,
            [
                'sku' => '823',
                'parent_sku' => '821',
                'name' => 'Cobertor Azul',
                'ean' => '7897905260881',
            ],
            $prices,
            $category
        );
    }

    public static function cradle(User $user, array $prices = [], ?Category $category = null): Product
    {
        return self::persisted(
            $user,
            [
                'sku' => '589',
                'name' => 'Berço',
                'ean' => '7898089223815',
            ],
            $prices,
            $category
        );
    }

    public static function kitCradleAndCarriage(User $user, array $prices = [], ?Category $category = null)
    {
        return self::persisted(
            $user,
            [
                'sku' => '601',
                'name' => 'Kit Berço e Carrinho',
                'ean' => '7898089223815',
                'composition_products' => ['589', '1234'],
            ],
            $prices,
            $category
        );
    }

    private static function persisted(
        User $user,
        array $data = [],
        array $prices = [],
        ?Category $category = null
    ): Product
    {
        $data = self::getData($data);
        $product = new Product($data);
        $product->user_id = $user->id;
        $product->save();

        foreach ($prices as $price) {
            $priceData = array_merge($price, [
                'product_sku' => $product->getSku(),
            ]);

            PriceData::persisted($user, $priceData);
        }

        if ($category) {
            $product->category()->associate($category);
            $product->save();
        }

        return $product->refresh();
    }

    private static function getData(array $data = []): array
    {
        return array_replace(
            [
                'erp_id' => '15865921214',
                'sku' => '3670',
                'ean' => '7908200101745',
                'name' => 'Canguru Balbi Vermelho',
                'brand' => 'Galzerano',
                'purchase_price' => 99.0,
                'tax_icms' => 12,
                'images' => [],
                'additional_costs' => 0.0,
                'depth' => 11,
                'height' => 25,
                'width' => 28,
                'weight' => 0.3,
                'parent_sku' => null,
                'has_variations' => false,
                'composition_products' => [],
                'is_active' => true,
                'category_id' => null,
                'quantity' => 10,
            ],
            $data
        );
    }
}
