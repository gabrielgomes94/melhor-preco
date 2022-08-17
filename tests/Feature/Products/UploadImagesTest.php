<?php

namespace Tests\Feature\Products;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Users\Concerns\UsersDatabase;
use Tests\FeatureTestCase;

class UploadImagesTest extends FeatureTestCase
{
    use UsersDatabase;

    public function test_should_render_upload_image_page(): void
    {
        $this->given_i_am_a_logged_user();

        $this->when_i_want_to_see_the_upload_image_page();

        $this->then_it_must_render_the_upload_image_page();
    }

    public function test_should_upload_images(): void
    {
        $this->given_i_am_a_logged_user();
        $this->given_i_have_a_bling_integration_setup();

        $this->when_i_want_to_upload_images();

        $this->then_it_must_render_the_upload_image_page();
        $this->then_it_must_flash_successful_message_on_session();
    }

    public function test_should_handle_errors_when_uploading_images(): void
    {
        $this->given_i_am_a_logged_user();
        $this->given_i_have_a_bling_integration_setup_with_error_response();

        $this->when_i_want_to_upload_images();

        $this->then_it_must_render_the_upload_image_page();
        $this->then_it_must_flash_error_message_on_session();
    }

    private function given_i_have_a_bling_integration_setup(): void
    {
        $response = $this->getJsonFixture('Bling/Products/single-product.json');

        Http::fake([
            "bling.com.br/Api/v2/produto/1234/*" => Http::response($response),
        ]);
    }

    private function given_i_have_a_bling_integration_setup_with_error_response(): void
    {
        $response = $this->getJsonFixture('Bling/Errors/404.json');

        Http::fake([
            "bling.com.br/Api/v2/produto/1234/*" => Http::response($response),
        ]);
    }

    private function then_it_must_flash_successful_message_on_session(): void
    {
        $this->response->assertSessionHas('message', 'Fotos atualizadas com sucesso.');
    }

    private function then_it_must_render_the_upload_image_page(): void
    {
        $this->response->assertViewIs('pages.products.upload-images.form');
    }

    private function then_it_must_flash_error_message_on_session(): void
    {
        $this->response->assertSessionHas('error', 'Erro: produto não foi enviado para o Bling.');
    }

    private function when_i_want_to_see_the_upload_image_page(): void
    {
        $this->response = $this->get('/produtos/upload-de-imagens');
    }

    private function when_i_want_to_upload_images(): void
    {
        Storage::fake('test');

        $this->response = $this->post('/produtos/upload-de-imagens', [
            'sku' => '1234',
            'name' => 'Carrinho de Bebê',
            'images' => [
                UploadedFile::fake()->image('foto1.png'),
                UploadedFile::fake()->image('foto2.png'),
                UploadedFile::fake()->image('foto3.png'),
            ],
        ]);
    }
}
