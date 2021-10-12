<?php

namespace Src\Products\Application\Services\Costs;

use Src\Products\Application\Imports\ProductICMSImport;
use Src\Products\Infrastructure\Repositories\GetDB;
use Src\Products\Application\Services\Update\UpdateCosts;
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
