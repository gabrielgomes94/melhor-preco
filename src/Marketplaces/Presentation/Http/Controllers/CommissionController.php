<?php

namespace Src\Marketplaces\Presentation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Src\Marketplaces\Application\UseCases\GetCategoryWithCommission;
use Src\Marketplaces\Domain\Models\Contracts\CommissionType;
use Src\Marketplaces\Domain\UseCases\Contracts\GetCommissionType;

class CommissionController extends Controller
{
    private GetCommissionType $getCommissionType;
    private GetCategoryWithCommission $getCategoryWithCommission;

    public function __construct(
        GetCommissionType $getCommissionType,
        GetCategoryWithCommission $getCategoryWithCommission
    ) {
        $this->getCommissionType = $getCommissionType;
        $this->getCategoryWithCommission = $getCategoryWithCommission;
    }

    public function setCommission(string $marketplaceUuid)
    {
        try {
            $commissionType = $this->getCommissionType->get($marketplaceUuid);
        } catch (\Throwable $exception) {
            abort(404);
        }

        if ($commissionType === CommissionType::CATEGORY_COMMISSION) {
            $data = $this->getCategoryWithCommission->get();

            return view('pages.marketplaces.set-commission.category', ['categories' => $data]);
        }

        if ($commissionType === CommissionType::SKU_COMMISSION) {
            return view('pages.marketplaces.set-commission.sku');
        }

        return view('pages.marketplaces.set-commission.unique');
    }

}
