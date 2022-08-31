<?php

namespace Tests\Data\Models\Products;

use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Users\Infrastructure\Laravel\Models\User;

class ProductData
{
    public static function babyCarriage(User $user, array $prices = [], ?Category $category = null): Product
    {
        return self::persisted(
            $user,
            [
                'sku' => '1234',
                'name' => 'Carrinho de Bebê',
                'ean' => '7908238800092',
                'purchase_price' => 449.90,
                'uuid' => 'fdb452fd-fc5f-4267-89dd-32e2010cb946',
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
                'uuid' => '6ff331cb-00dd-463f-8f5e-f26999cd28d8',
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
                'uuid' => 'd6ff4ff5-8123-4ed1-b231-e3784cdd2e69',
                'is_active' => false,
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
                'uuid' => 'bc2616a8-dc88-4b96-aed5-0c5c3615de7f',
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
                'uuid' => 'eb6dcab0-d141-4e48-95c4-79c6a6dbf25d',
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
                'uuid' => '01403075-1482-4571-bc75-d91026cff6cb',
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
                'uuid' => '56e6073e-f014-48ad-ba19-55d4288a8841',
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
                'uuid' => '79a246ac-1f5b-4136-81de-3a69f82575d2',
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
        $product->uuid = $data['uuid'];
        $product->save();

        $product->prices()->saveMany($prices);


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
