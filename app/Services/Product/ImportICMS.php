<?php

namespace App\Services\Product;

use App\Imports\ProductICMSImport;
use App\Models\Product;
use App\Repositories\Pricing\Product\Updator as UpdateRepository;
use App\Repositories\Product\FinderDB;
use Barrigudinha\Product\Services\Update;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportICMS
{
    private FinderDB $finder;
    private UpdateRepository $repository;
    private Update $updateService;

    public function __construct(UpdateRepository $repository, FinderDB $finder, Update $updateService)
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
            $this->updateService->updateCosts(
                $productObject,
                ['taxICMS' => (float) $product['icms']]
            );

            $this->repository->sync($productObject, $model);
        }
    }
}
