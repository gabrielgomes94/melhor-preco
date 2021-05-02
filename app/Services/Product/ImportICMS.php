<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Repositories\Pricing\Product\Updator as UpdateRepository;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportICMS
{
    private UpdateRepository $repository;

    public function __construct(UpdateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(UploadedFile $file)
    {
        $spreadsheet = IOFactory::load($file);
        $worksheet  = $spreadsheet->getActiveSheet();

        for ($row = 2; $row <= $worksheet->getHighestRow(); ++$row) {
            $sku = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
            $sku = trim($sku);

            $icms = $worksheet->getCellByColumnAndRow(35, $row)->getValue();
            $icms = (float) str_replace(',', '.', $icms);

            $q = $this->repository->updateICMS($sku, $icms);
        }
    }
}
