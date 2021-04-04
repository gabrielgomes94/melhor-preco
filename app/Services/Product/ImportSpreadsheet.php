<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * TODO: Melhorar essa classe futuramente:
 *  - validar a estrutura da planilha e retornar erros
 *  - melhorar lógica para pegar os dados
 *  - criar um repositório para desacoplar as responsabilidades.
 *
 */
class ImportSpreadsheet
{
    public function execute(UploadedFile $file)
    {
        $spreadsheet = IOFactory::load($file);
        $worksheet  = $spreadsheet->getActiveSheet();

        for ($row = 2; $row <= $worksheet->getHighestRow(); ++$row) {
            $sku = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
            $sku = trim($sku);
            $name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
            $purchasePrice = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
            $purchasePrice = str_replace(',', '.', $purchasePrice);
            $ipi = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
            $icms = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
            $simplesNacional = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
            $skuMagalu = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
            $skuB2w = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
            $skuMercadoLivre = $worksheet->getCellByColumnAndRow(9, $row)->getValue();

            $product = new Product(
                [
                    'sku' => $sku,
                    'name' => $name,
                    'purchase_price' => $purchasePrice,
                    'sku_magalu' => $skuMagalu,
                    'sku_b2w' => $skuB2w,
                    'sku_mercado_livre' => $skuMercadoLivre,
                    'tax_ipi' => $ipi,
                    'tax_icms' => $icms,
                    'tax_simples_nacional' => $simplesNacional,
                ]
            );

            $product->save();
        }
    }
}
