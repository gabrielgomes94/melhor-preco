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

    public function execute(UploadedFile $file)
    {
        $productImport = (new ProductICMSImport());
        $productImport->import($file);
        $products = $productImport->get();

        foreach ($products as $product) {
            if (!$model = $this->finder->getModel($product['sku'])) {
                continue;
            }

            $productObject = $model->toDomainObject();

            $this->updateService->execute(
                $product['sku'],
                ['taxICMS' => (float) $product['icms']]
            );
        }
    }
}
