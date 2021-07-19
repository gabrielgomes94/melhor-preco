<?php

namespace App\Services\Product;

use App\Imports\ProductICMSImport;
use App\Repositories\Pricing\Product\Updator as UpdateRepository;
use App\Repositories\Product\FinderDB;
use Illuminate\Http\UploadedFile;


class ImportICMS
{
    private FinderDB $finder;
    private UpdateRepository $repository;
    private UpdateCosts $updateService;

    public function __construct(UpdateRepository $repository, FinderDB $finder, UpdateCosts $updateService)
    {
        $this->repository = $repository;
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

            $this->repository->sync($productObject, $model);
        }
    }
}
