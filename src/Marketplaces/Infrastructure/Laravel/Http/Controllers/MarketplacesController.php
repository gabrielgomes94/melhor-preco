<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\MarketplaceRepository;
use Src\Marketplaces\Infrastructure\Laravel\Http\Requests\SaveMarketplaceRequest;
use Src\Marketplaces\Infrastructure\Laravel\Presenters\MarketplacePresenter;

class MarketplacesController extends Controller
{
    public function __construct(
        private readonly MarketplacePresenter $marketplacePresenter,
        private readonly MarketplaceRepository $marketplaceRepository
    ) {
    }

    public function create(): View|Factory
    {
        return view('pages.marketplaces.create');
    }

    /**
     * @throws MarketplaceNotFoundException
     */
    public function edit(string $marketplaceSlug): View|Factory
    {
        $marketplace = $this->getMarketplace($marketplaceSlug);
        $marketplace = $this->marketplacePresenter->present($marketplace);

        return view('pages.marketplaces.edit', [
            'marketplace' => $marketplace,
        ]);
    }

    public function list(): View|Factory
    {
        $userId = auth()->user()->getAuthIdentifier();
        $marketplaces = $this->marketplaceRepository->list($userId);
        $data = $this->marketplacePresenter->presentList(collect($marketplaces));

        return view('pages.marketplaces.list', $data);
    }

    public function store(SaveMarketplaceRequest $request): RedirectResponse
    {
        $this->marketplaceRepository->create($request->transform());

        return redirect()->route('marketplaces.list');
    }

    /**
     * @throws MarketplaceNotFoundException
     */
    public function update(SaveMarketplaceRequest $request, string $marketplaceSlug): RedirectResponse
    {
        $marketplace = $this->getMarketplace($marketplaceSlug);
        $this->marketplaceRepository->update($marketplace, $request->transform());

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
}
