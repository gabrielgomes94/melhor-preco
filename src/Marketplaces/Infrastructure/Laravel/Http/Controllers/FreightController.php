<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Infrastructure\Laravel\Http\Requests\UpdateCommissionRequest;
use Src\Marketplaces\Infrastructure\Laravel\Presenters\MarketplacePresenter;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\FreightRepository;

class FreightController extends Controller
{
    public function __construct(
        private FreightRepository $freightRepository,
        private MarketplaceRepository $marketplaceRepository,
        private MarketplacePresenter $marketplacePresenter
    ) {
    }

    public function edit(string $marketplaceSlug): View
    {
        $userId = auth()->user()->getAuthIdentifier();
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug, $userId);
        $data = $this->marketplacePresenter->present($marketplace);

        return view('pages.marketplaces.set-freight', $data);
    }

    public function update(UpdateCommissionRequest $request, string $marketplaceSlug): RedirectResponse
    {
        $userId = auth()->user()->getAuthIdentifier();
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug, $userId);

        $this->freightRepository->update($marketplace, $request->transform());

        return redirect()->back();
    }
}
