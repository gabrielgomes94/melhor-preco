<?php

namespace Src\Products\Application\Services;

use Exception;
use Src\Products\Application\Imports\ProductICMSImport;
use Src\Products\Application\UseCases\UpdateCosts;

class ImportICMS
{
    private UpdateCosts $updateService;

    public function __construct(UpdateCosts $updateService)
    {
        $this->updateService = $updateService;
    }

    public function execute(string $filepath)
    {
        $productImport = (new ProductICMSImport());
        $productImport->import($filepath);
        $products = $productImport->get();

        foreach ($products as $product) {
            try {
                $this->updateService->execute(
                    $product['sku'],
                    ['taxICMS' => (float) $product['icms']]
                );
            } catch (Exception $exception) {
                continue;
            }
        }
    }
}
