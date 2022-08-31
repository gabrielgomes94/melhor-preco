<?php

namespace Tests\Feature\Products;

use Src\Products\Domain\Models\Category;
use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Products\ProductData;
use Tests\Feature\Users\Concerns\UsersDatabase;
use Tests\FeatureTestCase;

class ListProductsTest extends FeatureTestCase
{
    use UsersDatabase;

    public function test_should_list_products()
    {
        $this->given_i_am_a_logged_user();
        $this->given_i_have_some_products();

        $this->when_i_want_to_list_products();

        $this->then_the_products_informations_report_view_must_be_rendered();
        $this->then_the_view_must_show_products_data();
    }

    public function test_should_list_products_filtering_by_category(): void
    {
        $this->given_i_am_a_logged_user();
        $this->given_i_have_some_products();

        $this->when_i_want_to_list_products_by_category();

        $this->then_the_products_informations_report_view_must_be_rendered();
        $this->then_the_view_must_show_products_data_filtered_by_category();
    }

    public function test_should_list_products_filtering_by_sku(): void
    {
        $this->given_i_am_a_logged_user();
        $this->given_i_have_some_products();

        $this->when_i_want_to_list_products_by_sku();

        $this->then_the_products_informations_report_view_must_be_rendered();
        $this->then_the_view_must_show_products_data_filtered_by_sku();
    }

    private function given_i_have_some_products(): void
    {
        $category = CategoryData::babyCarriage($this->user);

        ProductData::babyCarriage($this->user, [], $category);
        ProductData::babyChair($this->user);
        ProductData::babyPacifier($this->user);
        ProductData::blanket($this->user);
        ProductData::redBlanket($this->user);
        ProductData::blueBlanket($this->user);
    }

    private function then_the_products_informations_report_view_must_be_rendered(): void
    {
        $this->response->assertViewIs('pages.products.reports.product_information');
        $this->response->assertViewHas('paginator');
    }

    private function then_the_view_must_show_products_data(): void
    {
        $this->response->assertViewHas('filter', [
            'categories' => [
                [
                    'name' => 'Carrinhos de Bebê',
                    'category_id' => '10',
                ],
            ],
            'sku' => null,
        ]);

        $this->response->assertViewHas('data', [
            [
                'sku' => '1234',
                'name' => 'Carrinho de Bebê',
                'imagesCount' => 0,
                'sales' => 0,
            ],
            [
                'sku' => '987',
                'name' => 'Cadeirinha para Carros',
                'imagesCount' => 0,
                'sales' => 0,
            ],
            [
                'sku' => '777',
                'name' => 'Chupeta',
                'imagesCount' => 0,
                'sales' => 0,
            ],
            [
                'sku' => '821',
                'name' => 'Cobertor',
                'imagesCount' => 0,
                'sales' => 0,
            ],
            [
                'sku' => '822',
                'name' => 'Cobertor Vermelho',
                'imagesCount' => 0,
                'sales' => 0,
            ],
            [
                'sku' => '823',
                'name' => 'Cobertor Azul',
                'imagesCount' => 0,
                'sales' => 0,
            ],
        ]);
    }

    private function then_the_view_must_show_products_data_filtered_by_category()
    {
        $this->response->assertViewHas('filter', [
            'categories' => [
                [
                    'name' => 'Carrinhos de Bebê',
                    'category_id' => '10',
                ],
            ],
            'sku' => null,
        ]);

        $this->response->assertViewHas('data', [
            [
                'sku' => '1234',
                'name' => 'Carrinho de Bebê',
                'imagesCount' => 0,
                'sales' => 0,
            ],
        ]);
    }

    private function then_the_view_must_show_products_data_filtered_by_sku(): void
    {
        $this->response->assertViewHas('filter', [
            'categories' => [
                [
                    'name' => 'Carrinhos de Bebê',
                    'category_id' => '10',
                ],
            ],
            'sku' => '821',
        ]);

        $this->response->assertViewHas('data', [
            [
                'sku' => '821',
                'name' => 'Cobertor',
                'imagesCount' => 0,
                'sales' => 0,
            ],
            [
                'sku' => '822',
                'name' => 'Cobertor Vermelho',
                'imagesCount' => 0,
                'sales' => 0,
            ],
            [
                'sku' => '823',
                'name' => 'Cobertor Azul',
                'imagesCount' => 0,
                'sales' => 0,
            ],
        ]);
    }

    private function when_i_want_to_list_products(): void
    {
        $this->response = $this->get('produtos/relatorios/informacoes-gerais');
    }

    private function when_i_want_to_list_products_by_category(): void
    {
        $this->response = $this->get('produtos/relatorios/informacoes-gerais?category=10');
    }

    private function when_i_want_to_list_products_by_sku()
    {
        $this->response = $this->get('produtos/relatorios/informacoes-gerais?sku=821');
    }
}
