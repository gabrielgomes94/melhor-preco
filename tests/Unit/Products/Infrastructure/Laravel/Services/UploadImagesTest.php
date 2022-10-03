<?php

namespace Src\Products\Infrastructure\Laravel\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Mockery;
use Src\Products\Domain\DataTransfer\ProductImages;
use Src\Products\Domain\Repositories\Erp\ProductRepository;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class UploadImagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_upload_images(): void
    {
        // Arrange
        $productRepository = Mockery::mock(ProductRepository::class);
        $service = new UploadImages($productRepository);
        $user = UserData::persisted();
        $productImages = new ProductImages(
            'Cadeira de Bebê',
            '1234',
            [
                UploadedFile::fake()->image('foto1.png'),
                UploadedFile::fake()->image('foto2.png'),
                UploadedFile::fake()->image('foto3.png'),
            ]
        );
        $path = '72ed161d26204cf94481f812902f4dc4fa66c7798b41831a0308b3648261971b/1234 - Cadeira de Bebê';

        // Expect
        $productRepository->expects()
            ->uploadImages('token', '1234', $path, $productImages->images)
            ->andReturnTrue();

        // Act
        $result = $service->execute($productImages, $user);

        // Assert
        $this->assertTrue($result);
    }
}
