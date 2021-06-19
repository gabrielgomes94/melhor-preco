<?php

namespace App\Http\Controllers\Front\Pricing\PriceList;

use App\Exports\B2W\PriceExport;
use App\Http\Controllers\Controller;
use App\Repositories\Pricing\PricingRepository;
use App\Services\Pricing\Spreadsheets\ExportPrices;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    private PricingRepository $repository;
    private ExportPrices $exportPrices;

    public function __construct(PricingRepository $repository, ExportPrices $exportPrices)
    {
        $this->exportPrices = $exportPrices;
        $this->repository = $repository;
    }

    public function export(string $id, Request $request)
    {
        $pricing = $this->repository->get($id);
        $products = collect($pricing->products)->sortBy('sku')->toArray();

        return Excel::download(new PriceExport($products), 'precos.csv');
    }
}
