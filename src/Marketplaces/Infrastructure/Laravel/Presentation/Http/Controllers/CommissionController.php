<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Presentation\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Domain\Models\Contracts\CommissionType;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Marketplaces\Infrastructure\Laravel\Presentation\Http\Requests\SetCommissionByCategoryRequest;
use Src\Marketplaces\Infrastructure\Laravel\Presentation\Http\Requests\SetUniqueCommissionRequest;
use Src\Marketplaces\Infrastructure\Laravel\Services\GetCategoriesWithCommissions;

class CommissionController extends Controller
{
    public function __construct(
        private GetCategoriesWithCommissions $getCategoryWithCommission,
        private CommissionRepository         $commissionRepository,
        private MarketplaceRepository        $marketplaceRepository
    ) {}

    /**
     * @throws MarketplaceNotFoundException
     */
    public function editCommission(string $marketplaceSlug): View|Factory
    {
        $marketplace = $this->getMarketplace($marketplaceSlug);

        if ($marketplace->getCommissionType() === CommissionType::CATEGORY_COMMISSION) {
            return $this->renderSetCommissionCategoryView($marketplace);
        }

        return view('pages.marketplaces.set-commission.unique', [
            'marketplaceSlug' => $marketplaceSlug,
        ]);
    }

    public function doSetCommissionByCategory(
        string $marketplaceSlug,
        SetCommissionByCategoryRequest $request
    ): RedirectResponse
    {
        $this->commissionRepository->updateCategoryCommissions($marketplaceSlug, $request->transform());

        return redirect()->route('marketplaces.list');
    }

    public function doSetUniqueCommission(
        string $marketplaceSlug,
        SetUniqueCommissionRequest $request
    ): RedirectResponse
    {
        $this->commissionRepository->updateUniqueCommission($marketplaceSlug, $request->transform());

        return redirect()->route('marketplaces.list');
    }

    /**
     * @throws MarketplaceNotFoundException
     */
    private function getMarketplace(string $marketplaceSlug): Marketplace
    {
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug);

        if (!$marketplace) {
            throw new MarketplaceNotFoundException($marketplaceSlug);
        }

        return $marketplace;
    }

    private function renderSetCommissionCategoryView(Marketplace $marketplace):  View|Factory
    {
        $userId = auth()->user()->getAuthIdentifier();
        $data = $this->getCategoryWithCommission->get($marketplace, $userId);

        return view('pages.marketplaces.set-commission.category', [
            'categories' => $data,
            'marketplaceSlug' => $marketplace->getSlug(),
        ]);
    }
}
