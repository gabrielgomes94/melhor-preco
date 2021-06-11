<?php

namespace App\Services\Product;

use App\Imports\ProductICMSImport;
use App\Models\Product;
use App\Repositories\Pricing\Product\Updator as UpdateRepository;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Facades\Excel;
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
        $productImport = (new ProductICMSImport());
        $productImport->import($file);
        $products = $productImport->get();

        foreach ($products as $product) {
            $this->repository->updateICMS($product['sku'], (float) $product['icms']);
        }
    }
}
