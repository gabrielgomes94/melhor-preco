<?php

namespace Tests\Unit\Integrations\Bling\Products\Transformer;

use Integrations\Bling\Products\Transformers\Transformer;
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
        $this->assertEmpty($result);
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
                    [
                        'link' => 'link-to-image-1',
                        'validade' => 'S/ Validade',
                        'tipoArmazenamento' => 'externo',
                    ],
                    [
                        'link' => 'link-to-image-2',
                        'validade' => 'S/ Validade',
                        'tipoArmazenamento' => 'externo',
                    ],
                    [
                        'link' => 'link-to-image-3',
                        'validade' => 'S/ Validade',
                        'tipoArmazenamento' => 'externo',
                    ],
                ],
                'estoqueAtual' => 0,
                'precoCusto' => 10.2,
                'preco' => 20
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
                'purchasePrice' => 10.2,
                'price' => 20
            ],
        ];

        // Act
        $result = $tranformer->transform($data);

        // Assert
        $this->assertSame($expected, $result);
    }
}
