<?php

namespace App\Http\Controllers\Front\Pricing;

use App\Exports\B2W\PriceExport;
use App\Http\Controllers\Controller;
use App\Repositories\Pricing\PricingRepository;
use App\Services\Pricing\Spreadsheets\ExportPrices;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportSpreadsheetController extends Controller
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

        return Excel::download(new PriceExport($pricing->products), 'precos.csv');
    }
}
