<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Presentation\Http\Controllers;

use Illuminate\Routing\Controller;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\MarketplaceRepository;
use Src\Marketplaces\Infrastructure\Laravel\Presentation\Http\Requests\SaveMarketplaceRequest;
use Src\Marketplaces\Infrastructure\Laravel\Presentation\Presenters\MarketplacePresenter;

class MarketplacesController extends Controller
{
    public function __construct(
        private MarketplacePresenter $marketplacePresenter,
        private MarketplaceRepository $marketplaceRepository
    ) {
    }

    public function create()
    {
        return view('pages.marketplaces.create');
    }

    public function edit(string $marketplaceUuid)
    {
        $marketplace = $this->marketplaceRepository->getByUuid($marketplaceUuid);

        if (!$marketplace) {
            throw new MarketplaceNotFoundException($marketplaceUuid);
        }

        $marketplace = $this->marketplacePresenter->present($marketplace);

        return view('pages.marketplaces.edit', [
            'marketplace' => $marketplace,
        ]);
    }

    public function list()
    {
        $marketplaces = $this->marketplaceRepository->list();
        $data = $this->marketplacePresenter->presentList($marketplaces);

        return view('pages.marketplaces.list', $data);
    }

    public function store(SaveMarketplaceRequest $request)
    {
        $this->marketplaceRepository->create($request->transform());

        return redirect()->route('marketplaces.list');
    }

    public function update(SaveMarketplaceRequest $request, string $marketplaceId)
    {
        $this->marketplaceRepository->update($request->transform(), $marketplaceId);

        return redirect()->route('marketplaces.list');
    }
}
