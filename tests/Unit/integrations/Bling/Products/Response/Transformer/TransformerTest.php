<?php

namespace Tests\Unit\Integrations\Bling\Products\Response\Transformer;

use Integrations\Bling\Products\Response\Transformers\Transformer;
use Tests\TestCase;

class TransformerTest extends TestCase
{
    public function testShouldNotTransformData(): void
    {
        // Set
        $tranformer = new Transformer();
        $data = [
            'foo' => [
                'bar' => 'xpto',
            ],
        ];

        // Act
        $result = $tranformer->transform($data);

        // Assert
        $this->assertSame($data, $result);
    }

    public function testShouldTransformData(): void
    {
        // Set
        $tranformer = new Transformer();
        $data = [
            'product' => [
                'codigo' => '1122',
                'descricao' => 'Carrinho de Bebê',
                'marca' => 'Galzerano',
                'imagem' => [
                    'link-to-image-1',
                    'link-to-image-2',
                    'link-to-image-3',
                ],
                'estoqueAtual' => 0,
            ],
        ];

        $expected = [
            'product' => [
                'sku' => '1122',
                'name' => 'Carrinho de Bebê',
                'brand' => 'Galzerano',
                'images' => [
                    'link-to-image-1',
                    'link-to-image-2',
                    'link-to-image-3',
                ],
                'stock' => 0,
            ],
        ];

        // Act
        $result = $tranformer->transform($data);

        // Assert
        $this->assertSame($expected, $result);
    }
}
