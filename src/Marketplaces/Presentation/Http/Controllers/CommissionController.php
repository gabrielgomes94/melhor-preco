<?php

namespace Src\Marketplaces\Presentation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Src\Marketplaces\Application\UseCases\GetCategoryWithCommission;
use Src\Marketplaces\Domain\Models\Contracts\CommissionType;
use Src\Marketplaces\Domain\UseCases\Contracts\GetCommissionType;
use Src\Marketplaces\Domain\UseCases\Contracts\UpdateCommission;
use Src\Marketplaces\Presentation\Http\Requests\SetCommissionByCategoryRequest;
use Src\Marketplaces\Presentation\Http\Requests\SetUniqueCommissionRequest;

class CommissionController extends Controller
{
    public function __construct(
        private GetCommissionType $getCommissionType,
        private GetCategoryWithCommission $getCategoryWithCommission,
        private UpdateCommission $updateCommission
    ) {}

    public function setCommission(string $marketplaceSlug)
    {
        try {
            $commissionType = $this->getCommissionType->get($marketplaceSlug);
        } catch (\Throwable $exception) {
            abort(404);
        }

        if ($commissionType === CommissionType::CATEGORY_COMMISSION) {
            $data = $this->getCategoryWithCommission->get($marketplaceSlug);

            return view('pages.marketplaces.set-commission.category', [
                'categories' => $data,
                'marketplaceSlug' => $marketplaceSlug,
            ]);
        }

        return view('pages.marketplaces.set-commission.unique', [
            'marketplaceSlug' => $marketplaceSlug,
        ]);
    }

    public function doSetCommissionByCategory(string $marketplaceSlug, SetCommissionByCategoryRequest $request)
    {
        $data = $this->transformInput($request);
        $this->updateCommission->massUpdate($marketplaceSlug, $data);

        return redirect()->route('marketplaces.list');
    }

    public function doSetUniqueCommission(string $marketplaceSlug, SetUniqueCommissionRequest $request)
    {
        $this->updateCommission->update($marketplaceSlug, (float) $request->validated()['commission']);

        return redirect()->route('marketplaces.list');
    }

    private function transformInput(Request $request)
    {
        $data = $request->all();
        $count = count($data['commission']);

        for ($i = 0; $i < $count; $i++) {
            $transformed[] = [
                'commission' => $data['commission'][$i],
                'categoryName' => $data['categoryName'][$i],
                'categoryId' => $data['categoryId'][$i],
            ];

        }

        return $transformed ?? [];
    }
}
