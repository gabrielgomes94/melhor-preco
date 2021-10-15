<?php

namespace Src\Prices\PriceList\Application\Http\Controllers\Web\PriceList;

use Src\Products\Application\Exports\BlingPriceExport;
use App\Http\Controllers\Controller;
use Src\Prices\PriceList\Infrastructure\Repositories\Product\ListDB;
use Src\Prices\PriceList\Infrastructure\Repositories\Options\Options;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    private ListDB $productsRepository;

    public function __construct(ListDB $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    public function exportStore(string $store, Request $request)
    {
        $options = new Options([
            'store' => $store
        ]);
        $products = $this->productsRepository->all($options);

        return Excel::download(new BlingPriceExport($products, $store), 'precos.csv');
    }
}
