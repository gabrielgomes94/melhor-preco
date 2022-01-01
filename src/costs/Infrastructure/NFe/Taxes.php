<?php

namespace Src\Costs\Infrastructure\NFe;

use SimpleXMLElement;

class Taxes
{
    private array $taxes = [
        'IPI',
        'ICMS',
//        'PIS',
//        'COFINS',
        'Importation'
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
        if (isset($tax['ICMS']['ICMS00'])) {
            return [
                'percentage' => $tax['ICMS']['ICMS00']['pICMS'] ?? 0.0,
            ];
        }

        return [
            'percentage' => 0.0,
        ];
    }
}
