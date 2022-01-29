<?php

namespace Src\Marketplaces\Presentation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Src\Marketplaces\Domain\UseCases\Contracts\CreateMarketplace;
use Src\Marketplaces\Domain\UseCases\Contracts\ListMarketplaces;
use Src\Marketplaces\Presentation\Http\Requests\SaveMarketplaceRequest;

class StoresController extends Controller
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

    public function create(Request $request)
    {
        return view('pages.marketplaces.create');
    }

    public function list(Request $request)
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
