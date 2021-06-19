<?php

namespace App\Http\Controllers\Front\Pricing\PriceList;

use App\Http\Controllers\Controller;
use App\Repositories\Pricing\PricingRepository;
use Illuminate\Http\Request;

class ExportController extends Controller
{
//    private ExportSpreadsheet $exportService;
    private PricingRepository $repository;

    public function __construct(PricingRepository $repository)
    {
        $this->repository = $repository;
//        $this->exportService = $exportService;
    }

    public function export(string $pricingId, Request $request): void
    {
//        if (!$pricing = $this->repository->find($pricingId)) {
//            abort(404);
//        }

//        $this->exportService->export($pricing);
    }
}
