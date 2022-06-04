<?php

namespace Tests\Data\NFe;

class ItemData
{
    public static function getNFeItem(): array
    {
        return [
            '@attributes' => [
                'nItem' => '1',
            ],
            'prod' => [
                'cProd' => '1190',
                'cEAN' => '7290108861822',
                'xProd' => 'Mobile Take Along Magical Tales',
                'NCM' => '95030010',
                'CEST' => '2806400',
                'indEscala' => 'S',
                'CFOP' => '2949',
                'uCom' => 'UN',
                'qCom' => '2.0000',
                'vUnCom' => '170.91000000',
                'vProd' => '170.91',
                'cEANTrib' => '7290108861822',
                'uTrib' => 'UN',
                'qTrib' => '1.0000',
                'vUnTrib' => '170.91000000',
                'indTot' => '1',
                'vFrete' => '10.0',
                'vSeg' => '5.0',
            ],
            'imposto' => [
                'vTotTrib' => '101.21',
                'ICMS' => [
                    'ICMSSN102' => [
                        'orig' => '1',
                        'CSOSN' => '400',
                    ],
                ],
                'PIS' => [
                    'PISAliq' => [
                        'CST' => '01',
                        'vBC' => '170.91',
                        'pPIS' => '0.00',
                        'vPIS' => '0.00',
                    ],
                ],
                'COFINS' => [
                    'COFINSAliq' => [
                        'CST' => '01',
                        'vBC' => '170.91',
                        'pCOFINS' => '0.00',
                        'vCOFINS' => '0.00',
                    ]
                ]
            ]
        ];
    }
}
