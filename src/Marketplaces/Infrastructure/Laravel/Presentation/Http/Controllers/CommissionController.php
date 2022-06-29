<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Presentation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Infrastructure\Laravel\Services\GetCategoryWithCommission;
use Src\Marketplaces\Domain\Models\Contracts\CommissionType;
use Src\Marketplaces\Domain\Services\UpdateCommission;
use Src\Marketplaces\Infrastructure\Laravel\Presentation\Http\Requests\SetCommissionByCategoryRequest;
use Src\Marketplaces\Infrastructure\Laravel\Presentation\Http\Requests\SetUniqueCommissionRequest;

/**
 * @todo: remove logic from controller
 */
class CommissionController extends Controller
{
    public function __construct(
        private GetCategoryWithCommission $getCategoryWithCommission,
        private UpdateCommission $updateCommission,
        private MarketplaceRepository $marketplaceRepository
    ) {}

    public function setCommission(string $marketplaceSlug)
    {
        $userId = auth()->user()->getAuthIdentifier();
        $commissionType = $this->getCommissionType($marketplaceSlug);

        if ($commissionType === CommissionType::CATEGORY_COMMISSION) {
            $data = $this->getCategoryWithCommission->get($marketplaceSlug, $userId);

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

    /**
     * @throws MarketplaceNotFoundException
     */
    public function getCommissionType(string $marketplaceSlug): string
    {
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug);

        if (!$marketplace) {
            throw new MarketplaceNotFoundException($marketplaceSlug);
        }

        return $marketplace->getCommissionType();
    }
}
