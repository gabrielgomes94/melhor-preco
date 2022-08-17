<?php

namespace Src\Products\Domain\DataTransfer;

use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\TestCase;

class ProductImagesTest extends TestCase
{
    public function test_should_instantiate_product_images(): void
    {
        // Act
        $images = [
            UploadedFile::fake()->image('foto1.png'),
            UploadedFile::fake()->image('foto2.png'),
            UploadedFile::fake()->image('foto3.png'),
        ];

        $instance = new ProductImages(
            'Carrinho de Bebê',
            '1234',
            $images
        );

        // Assert
        $this->assertSame('Carrinho de Bebê', $instance->name);
        $this->assertSame('1234', $instance->sku);
        $this->assertEquals($images, $instance->images);
    }
}
