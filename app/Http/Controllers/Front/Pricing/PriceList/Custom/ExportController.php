<?php

namespace App\Http\Controllers\Front\Pricing\PriceList\Custom;

use App\Exports\B2W\PriceExport;
use App\Http\Controllers\Controller;
use App\Repositories\Pricing\PricingRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    private PricingRepository $priceListRepository;

    public function __construct(PricingRepository $priceListRepository)
    {
        $this->priceListRepository = $priceListRepository;
    }

    public function export(string $id, Request $request)
    {
        $pricing = $this->priceListRepository->get($id);
        $products = collect($pricing->products)->sortBy('sku')->toArray();

        return Excel::download(new PriceExport($products), 'precos.csv');
    }
}
