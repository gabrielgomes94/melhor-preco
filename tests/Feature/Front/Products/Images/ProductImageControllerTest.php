<?php

namespace Tests\Feature\Front\Products\Images;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Integrations\Bling\Products\Requests\PostRequest;
use Tests\TestCase;

class ProductImageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_upload_images(): void
    {
        // Set
        Session::start();
        $user = User::factory()->create();
        Storage::fake('public');

        $input = [
            'sku' => '1234',
            'brand' => 'Kyly',
            'name' => 'Vestido de Bolinhas',
            'images' => [
                UploadedFile::fake()->create(public_path('image_1.jpg')),
                UploadedFile::fake()->create(public_path('image_2.jpg')),
            ],
            '_token' => csrf_token(),
        ];

        $mock = new MockHandler([
            new Response(
                200,
                [],
                $this->getFixture('Bling/Products/products.json')
            ),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $this->app->bind(PostRequest::class, function () use ($client) {
            return new PostRequest($client);
        });

        // Actions
        $response = $this
            ->actingAs($user)
            ->post('/product/file-upload', $input);

        // Assertions
        $response->assertStatus(200);
        $response->assertSessionHas('message', 'Fotos atualizadas com sucesso.');
        $response->assertSessionHasNoErrors();
        Storage::disk('public')->assertExists('Kyly/1234 - Vestido de Bolinhas/image_1.jpg');
        Storage::disk('public')->assertExists('Kyly/1234 - Vestido de Bolinhas/image_2.jpg');
    }

    public function test_should_not_upload_images_when_there_are_missing_parameters(): void
    {
        // Set
        Session::start();
        $user = User::factory()->create();
        Storage::fake('public');

        $input = [
            'sku' => '1234',
            'images' => [
                UploadedFile::fake()->create(public_path('image_1.jpg')),
                UploadedFile::fake()->create(public_path('image_2.jpg')),
            ],
            '_token' => csrf_token(),
        ];

        // Actions
        $response = $this
            ->actingAs($user)
            ->post('/product/file-upload', $input);

        // Assertions
        $response->assertStatus(302);
        $response->assertSessionHasErrors('name', 'O campo nome é obrigatório.');
        $response->assertSessionHasErrors('brand', 'O campo marca é obrigatório.');
    }

    public function test_should_not_upload_images_when_there_are_erros_on_bling_request(): void
    {
        // Set
        Session::start();
        $user = User::factory()->create();
        Storage::fake('public');

        $input = [
            'sku' => '1234',
            'brand' => 'Kyly',
            'name' => 'Vestido de Bolinhas',
            'images' => [
                UploadedFile::fake()->create(public_path('image_1.jpg')),
                UploadedFile::fake()->create(public_path('image_2.jpg')),
            ],
            '_token' => csrf_token(),
        ];

        $mock = new MockHandler([
            new Response(
                200,
                [],
                $this->getFixture('Bling/Products/products-with-errors.json')
            ),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $this->app->bind(PostRequest::class, function () use ($client) {
            return new PostRequest($client);
        });

        // Actions
        $response = $this
            ->actingAs($user)
            ->post('/product/file-upload', $input);

        // Assertions
        $response->assertStatus(200);
        $response->assertSessionHas('error', 'Erro: produto não foi enviado para o Bling.');
        $response->assertSessionHasNoErrors();
        Storage::disk('public')->assertExists('Kyly/1234 - Vestido de Bolinhas/image_1.jpg');
        Storage::disk('public')->assertExists('Kyly/1234 - Vestido de Bolinhas/image_2.jpg');
    }
}
