<?php

namespace Src\Marketplaces\Presentation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Src\Marketplaces\Application\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Application\UseCases\GetMarketplace;
use Src\Marketplaces\Domain\UseCases\Contracts\CreateMarketplace;
use Src\Marketplaces\Domain\UseCases\Contracts\ListMarketplaces;
use Src\Marketplaces\Presentation\Http\Requests\SaveMarketplaceRequest;
use Src\Marketplaces\Presentation\Presenters\MarketplacePresenter;

class MarketplacesController extends Controller
{
    public function __construct(
        private CreateMarketplace $createStore,
        private GetMarketplace $getMarketplace,
        private ListMarketplaces $listMarketplaces,
        private MarketplacePresenter $marketplacePresenter
    ) {}

    public function create()
    {
        return view('pages.marketplaces.create');
    }

    public function edit(string $marketplaceId)
    {
        try {
            $marketplace = $this->getMarketplace->get($marketplaceId);
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
        $this->createStore->create($request->validated());

        return redirect()->route('marketplaces.list');
    }

    public function update(Request $request, string $marketplaceId)
    {
        dd($marketplaceId);

    }
}
