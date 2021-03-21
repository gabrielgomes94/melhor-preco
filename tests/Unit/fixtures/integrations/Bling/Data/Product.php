<?php


namespace Tests\Unit\fixtures\integrations\Bling\Data;


class Product
{
    public static function getData(): array
    {
        return [
            'id' => '9811833249',
            'codigo' => '1211',
            'descricao' => 'Carrinho Veneto Aviador Azul',
            'tipo' => 'P',
            'situacao' => 'Ativo',
            'unidade' => '',
            'preco' => '459.9000000000',
            'precoCusto' => null,
            'descricaoCurta' => 'Detalhes do produto',
            'descricaoComplementar' => '',
            'dataInclusao' => '2020-10-14',
            'dataAlteracao' => '2021-02-18',
            'imageThumbnail' => null,
            'urlVideo' => '',
            'nomeFornecedor' => '',
            'codigoFabricante' => '',
            'marca' => 'Galzerano',
            'class_fiscal' => '',
            'cest' => '28.059.00',
            'origem' => '0',
            'idGrupoProduto' => '0',
            'linkExterno' => '',
            'observacoes' => '',
            'grupoProduto' => null,
            'garantia' => null,
            'descricaoFornecedor' => null,
            'idFabricante' => '',
            'categoria' => [
                'id' => '2005047',
                'descricao' => 'Carrinhos',
            ],
            'pesoLiq' => '7.23500',
            'pesoBruto' => '7.40000',
            'estoqueMinimo' => '0.00',
            'estoqueMaximo' => '0.00',
            'gtin' => '7898089221217',
            'gtinEmbalagem' => '7898089221217',
            'larguraProduto' => '40.00',
            'alturaProduto' => '80.00',
            'profundidadeProduto' => '25.00',
            'unidadeMedida' => 'Centímetros',
            'itensPorCaixa' => 1,
            'volumes' => 1,
            'localizacao' => '',
            'crossdocking' => '0',
            'condicao' => 'Novo',
            'freteGratis' => 'N',
            'producao' => 'T',
            'dataValidade' => '0000-00-00',
            'spedTipoItem' => '00',
            'imagem' => [
                [
                    'link' => 'https://barrigudinha-fotos-v2.s3.sa-east-1.amazonaws.com/Galzerano%2F1211+-+Carrinho+Veneto+Aviador+Azul%2F1243824160_1GG.jpg',
                    'validade' => 'S/ Validade',
                    'tipoArmazenamento' => 'externo',
                ],
                [
                    'link' => 'https://barrigudinha-fotos-v2.s3.sa-east-1.amazonaws.com/Galzerano%2F1211+-+Carrinho+Veneto+Aviador+Azul%2F1243824160_2GG.jpg',
                    'validade' => 'S/ Validade',
                    'tipoArmazenamento' => 'externo',
                ],
            ],
            'camposCustomizados' => [
                'tipoDeCarrinho' => 'De passeio',
                'marca' => 'Galzerano',
                'modelo' => 'Veneto',
                'corPrincipal' => 'Azul',
                'capacidadeDoCarrinho' => '1',
                'alturaAbertocm' => '103',
                'larguraAbertocm' => '51',
                'profundidadeAbertocm' => '78',
                'pesoMaximoSuportadokg' => '15',
                'eReclinavel' => 'true',
                'quantidadeDePosicoesDeReclinado' => '3',
                'incluiTravelSystem' => 'false',
                'e3Em1' => 'false',
            ],
            'estoqueAtual' => 0,
            'depositos' => [
                [
                    'deposito' => [
                        'id' => '8589125692',
                        'nome' => 'Loja Digital',
                        'saldo' => '0.0000000000',
                        'desconsiderar' => 'N',
                        'saldoVirtual' => '0.0000000000',
                    ],
                ],
                [
                    'deposito' => [
                        'id' => '9382052847',
                        'nome' => 'Loja Física',
                        'saldo' => 0,
                        'desconsiderar' => 'N',
                        'saldoVirtual' => 0,
                    ],
                ],
            ],
        ];
    }
}
