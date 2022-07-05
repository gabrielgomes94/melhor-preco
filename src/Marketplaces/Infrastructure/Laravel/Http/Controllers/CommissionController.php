<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Domain\Models\CommissionType;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Marketplaces\Infrastructure\Laravel\Http\Requests\SetCommissionByCategoryRequest;
use Src\Marketplaces\Infrastructure\Laravel\Http\Requests\SetUniqueCommissionRequest;
use Src\Marketplaces\Infrastructure\Laravel\Presenters\CategoriesPresenter;

class CommissionController extends Controller
{
    public function __construct(
        private CategoriesPresenter   $getCategoryWithCommission,
        private CommissionRepository  $commissionRepository,
        private MarketplaceRepository $marketplaceRepository
    ) {}

    /**
     * @throws MarketplaceNotFoundException
     */
    public function editCommission(string $marketplaceSlug): View|Factory
    {
        $marketplace = $this->getMarketplace($marketplaceSlug);

        if ($marketplace->getCommission()->hasCommissionByCategory()) {//Type() === CommissionType::CATEGORY_COMMISSION) {
            return $this->renderSetCommissionCategoryView($marketplace);
        }

        return view('pages.marketplaces.set-commission.unique', [
            'marketplaceSlug' => $marketplaceSlug,
        ]);
    }

    /**
     * @throws MarketplaceNotFoundException
     */
    public function doSetCommissionByCategory(
        string $marketplaceSlug,
        SetCommissionByCategoryRequest $request
    ): RedirectResponse
    {
        $marketplace = $this->getMarketplace($marketplaceSlug);
        $this->commissionRepository->updateCategoryCommissions($marketplace, $request->transform());

        return redirect()->route('marketplaces.list');
    }

    /**
     * @throws MarketplaceNotFoundException
     */
    public function doSetUniqueCommission(
        string $marketplaceSlug,
        SetUniqueCommissionRequest $request
    ): RedirectResponse
    {
        $marketplace = $this->getMarketplace($marketplaceSlug);
        $this->commissionRepository->updateUniqueCommission($marketplace, $request->transform());

        return redirect()->route('marketplaces.list');
    }

    /**
     * @throws MarketplaceNotFoundException
     */
    private function getMarketplace(string $marketplaceSlug): Marketplace
    {
        $userId = auth()->user()->getAuthIdentifier();
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug, $userId);

        if (!$marketplace) {
            throw new MarketplaceNotFoundException($marketplaceSlug);
        }

        return $marketplace;
    }

    private function renderSetCommissionCategoryView(Marketplace $marketplace):  View|Factory
    {
        $userId = auth()->user()->getAuthIdentifier();
        $data = $this->getCategoryWithCommission->presentWithCommission($marketplace, $userId);

        return view('pages.marketplaces.set-commission.category', [
            'categories' => $data,
            'marketplaceSlug' => $marketplace->getSlug(),
        ]);
    }
}
