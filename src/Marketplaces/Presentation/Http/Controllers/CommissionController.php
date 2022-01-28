<?php

namespace Src\Marketplaces\Presentation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Src\Marketplaces\Application\UseCase\GetCommissionType;
use Src\Marketplaces\Domain\Models\Contracts\CommissionType;

class CommissionController extends Controller
{
    private GetCommissionType $getCommissionType;

    public function __construct(GetCommissionType $getCommissionType)
    {
        $this->getCommissionType = $getCommissionType;
    }

    public function setCommission(Request $request, string $marketplaceUuid)
    {
        try {
            $commissionType = $this->getCommissionType->get($marketplaceUuid);
        } catch (\Throwable $exception) {
            abort(404);
        }

        if ($commissionType === CommissionType::CATEGORY_COMMISSION) {
            return view('marketplaces.set-commission.category');
        }

        if ($commissionType === CommissionType::SKU_COMMISSION) {
            return view('marketplaces.set-commission.sku');
        }

        return view('marketplaces.set-commission.unique');
    }

}
