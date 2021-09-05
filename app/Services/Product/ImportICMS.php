<?php

namespace App\Services\Product;

use App\Imports\ProductICMSImport;
use App\Repositories\Product\GetDB;
use App\Services\Product\Update\UpdateCosts;
use Illuminate\Http\UploadedFile;

class ImportICMS
{
    private GetDB $finder;
    private UpdateCosts $updateService;

    public function __construct(GetDB $finder, UpdateCosts $updateService)
    {
        $this->finder = $finder;
        $this->updateService = $updateService;
    }

    public function execute(string $filepath)
    {
        $productImport = (new ProductICMSImport());
        $productImport->import($filepath);
        $products = $productImport->get();

        foreach ($products as $product) {
            if (!$this->finder->getModel($product['sku'])) {
                continue;
            }

            $this->updateService->execute(
                $product['sku'],
                ['taxICMS' => (float) $product['icms']]
            );
        }
    }
}
