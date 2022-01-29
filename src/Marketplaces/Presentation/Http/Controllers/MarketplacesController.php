<?php

namespace Src\Marketplaces\Presentation\Http\Controllers;

use Illuminate\Routing\Controller;
use Src\Marketplaces\Domain\UseCases\Contracts\CreateMarketplace;
use Src\Marketplaces\Domain\UseCases\Contracts\ListMarketplaces;
use Src\Marketplaces\Presentation\Http\Requests\SaveMarketplaceRequest;

class MarketplacesController extends Controller
{
    private CreateMarketplace $createStore;
    private ListMarketplaces $listMarketplaces;

    public function __construct(
        CreateMarketplace $createStore,
        ListMarketplaces $listMarketplaces
    ) {
        $this->createStore = $createStore;
        $this->listMarketplaces = $listMarketplaces;
    }

    public function create()
    {
        return view('pages.marketplaces.create');
    }

    public function list()
    {
        $data = $this->listMarketplaces->list();

        return view('pages.marketplaces.list', $data);
    }

    public function store(SaveMarketplaceRequest $request)
    {
        $this->createStore->create($request->validated());

        return redirect()->route('marketplaces.list');
    }
}
