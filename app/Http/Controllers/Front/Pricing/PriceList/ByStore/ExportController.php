<?php

namespace App\Http\Controllers\Front\Pricing\PriceList\ByStore;

use App\Exports\BlingPriceExport;
use App\Http\Controllers\Controller;
use App\Repositories\Product\FinderDB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    private FinderDB $productsRepository;

    public function __construct(FinderDB $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    public function exportStore(string $store, Request $request)
    {
        $products = $this->productsRepository->allByStore($store);

        return Excel::download(new BlingPriceExport($products, $store), 'precos.csv');
    }
}
