<?php

namespace App\Services\Pricing\Spreadsheets;

use App\Exports\B2W\PriceExport;
use Barrigudinha\Pricing\Data\Pricing;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExportPrices
{
    public function export(Pricing $pricing)
    {
//        $inputFileName = 'storage/b2w_base.csv';

//        $spreadsheet = IOFactory::load($inputFileName);
//        $cellValue = $spreadsheet->getActiveSheet()->getCell('A1')->getValue();
//        $cellValue = $spreadsheet->getActiveSheet()->getCell('B1')->getValue();
//        $cellValue = $spreadsheet->getActiveSheet()->getCell('A1')->getValue();
//        $cellValue = $spreadsheet->getActiveSheet()->getCell('A1')->getValue();

//        dd(collect($pricing->products));

//        $export = new PriceExport();
//        foreach ($pricing->products as $product) {
//
//        }

//        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Csv");
//        $writer->save("storage/05featuredemo.csv");
//
//        dd($cellValue);
    }
}
