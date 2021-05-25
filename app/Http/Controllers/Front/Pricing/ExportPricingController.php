<?php

namespace App\Http\Controllers\Front\Pricing;

use App\Http\Controllers\Controller;
use App\Repositories\Pricing\PricingRepository;
use App\Services\Pricing\ExportSpreadsheet;
use Illuminate\Http\Request;

class ExportPricingController extends Controller
{
    private ExportSpreadsheet $exportService;
    private PricingRepository $repository;

    public function __construct(PricingRepository $repository, ExportSpreadsheet $exportService)
    {
        $this->repository = $repository;
        $this->exportService = $exportService;
    }

    public function export(string $pricingId, Request $request)
    {
        if (!$pricing = $this->repository->find($pricingId)) {
            abort(404);
        }

        $this->exportService->export($pricing);
    }
}
