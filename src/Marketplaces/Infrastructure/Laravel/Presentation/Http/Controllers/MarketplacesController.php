<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Presentation\Http\Controllers;

use Illuminate\Routing\Controller;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Infrastructure\Laravel\Services\GetMarketplace;
use Src\Marketplaces\Domain\UseCases\Contracts\SaveMarketplace;
use Src\Marketplaces\Domain\UseCases\Contracts\ListMarketplaces;
use Src\Marketplaces\Infrastructure\Laravel\Presentation\Http\Requests\SaveMarketplaceRequest;
use Src\Marketplaces\Infrastructure\Laravel\Presentation\Presenters\MarketplacePresenter;

class MarketplacesController extends Controller
{
    public function __construct(
        private SaveMarketplace $saveStore,
        private GetMarketplace $getMarketplace,
        private ListMarketplaces $listMarketplaces,
        private MarketplacePresenter $marketplacePresenter
    ) {
    }

    public function create()
    {
        return view('pages.marketplaces.create');
    }

    public function edit(string $marketplaceUuid)
    {
        try {
            $marketplace = $this->getMarketplace->getByUuid($marketplaceUuid);
        } catch (MarketplaceNotFoundException $exception) {
            abort(404);
        }

        $marketplace = $this->marketplacePresenter->present($marketplace);

        return view('pages.marketplaces.edit', [
            'marketplace' => $marketplace,
        ]);
    }

    public function list()
    {
        $marketplaces = $this->listMarketplaces->list();
        $data = $this->marketplacePresenter->presentList($marketplaces);

        return view('pages.marketplaces.list', $data);
    }

    public function store(SaveMarketplaceRequest $request)
    {
        $this->saveStore->save($request->transform());

        return redirect()->route('marketplaces.list');
    }

    public function update(SaveMarketplaceRequest $request, string $marketplaceId)
    {
        $this->saveStore->save($request->transform(), $marketplaceId);

        return redirect()->route('marketplaces.list');
    }
}
