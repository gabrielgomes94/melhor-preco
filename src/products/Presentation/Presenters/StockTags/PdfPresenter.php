<?php

namespace Src\Products\Presentation\Presenters\StockTags;

use PDF;

class PdfPresenter
{
    public function generate(array $qrCodes)
    {
        $i = 0;
        $j = 0;

        foreach ($qrCodes as $qrCode) {
            ++$i;

            $productsCollection[$j][] = $qrCode;

            if ($i % 9 === 0)  {
                ++$j;
            }
        }

        $pdf = PDF::loadView(
            'pages.products.stock_tags.document',
            ['products' => $productsCollection ?? []]
        );
        $pdf->setPaper('A4', 'landscape');

        return $pdf;
    }
}
