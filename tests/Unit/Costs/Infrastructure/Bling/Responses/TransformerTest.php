<?php

namespace Tests\Unit\Costs\Infrastructure\Bling\Responses;

use Src\Costs\Infrastructure\Bling\Responses\Transformer;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseInvoice;
use Tests\TestCase;

class TransformerTest extends TestCase
{
    public function test_should_transform_purchase_invoice(): void
    {
        // Set
        $data = [
            'chaveAcesso' => '12344',
            'contato' => 'COMPANHIA DOREL BRASIL PRODUTOS INFANTIS',
            'cnpj' => '10659948000107',
            'dataEmissao' => '2021-02-27 11:28:00',
            'numero' => '248284',
            'serie' => '1',
            'situacao' => 'Registrada',
            'valorNota' => '2477.37',
            'xml' => 'https://bling.com.br/relatorios/nfe.xml.php?s&chaveAcesso=12344',
            'linkDanfe' => 'https://bling.com.br/doc.view.php?id=6ee008d7410d317b534da630098d7a85',
        ];

        // Act
        $result = Transformer::transform($data);

        // Assert
        $this->assertInstanceOf(PurchaseInvoice::class, $result);
    }
}
