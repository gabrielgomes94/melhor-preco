<?php

namespace Src\Costs\Infrastructure\NFe;

class Taxes
{
    private array $taxes = [
        'IPI',
        'ICMS',
        'Importation' // II
    ];

    public static function getIPI(array $tax): array
    {
        if (isset($tax['IPI']['IPITrib'])) {
            $tributation = $tax['IPI']['IPITrib'];

            return [
                'value' => $tributation['vIPI'],
                'percentage' => $tributation['pIPI'],
            ];
        }

        return [
            'value' => 0.0,
            'percentage' => 0.0,
        ];
    }

    public static function getICMS(array $tax): array
    {
        $groupICMS = [
            'ICMS00',
            'ICMS10',
            'ICMS20',
            'ICMS30',
            'ICMS40',
            'ICMS41',
            'ICMS50',
            'ICMS51',
            'ICMS60',
            'ICMS70',
            'ICMS90',
        ];

        foreach ($groupICMS as $icms) {
            if (isset($tax['ICMS'][$icms])) {
                return [
                    'percentage' => $tax['ICMS'][$icms]['pICMS'] ?? 0.0,
                ];
            }
        }

        return [
            'percentage' => 0.0,
        ];
    }

    public static function getPIS(array $tax): array
    {
        if (isset($tax['PIS'])) {
            return [
                'percentage' => $tax['PIS']['pPIS'] ?? 0.0,
                'value' => $tax['PIS']['vPIS'] ?? 0.0,
            ];
        }

        return [
            'percentage' => 0.0,
            'value' => 0.0,
        ];
    }

    public static function getCOFINS(array $tax): array
    {
        if (isset($tax['COFINS'])) {
            return [
                'percentage' => $tax['COFINS']['pCOFINS'] ?? 0.0,
                'value' => $tax['COFINS']['vCOFINS'] ?? 0.0,
            ];
        }

        return [
            'percentage' => 0.0,
            'value' => 0.0,
        ];
    }
}
