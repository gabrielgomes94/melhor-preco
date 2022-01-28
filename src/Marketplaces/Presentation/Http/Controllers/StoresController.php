<?php

namespace Src\Marketplaces\Presentation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Src\Marketplaces\Application\UseCase\CreateMarketplace;
use Src\Marketplaces\Infrastructure\Laravel\Eloquent\MarketplaceRepository;
use Src\Marketplaces\Presentation\Presenters\MarketplacePresenter;

class StoresController extends Controller
{
    private CreateMarketplace $createStore;
    private MarketplaceRepository $marketplaceRepository;
    private MarketplacePresenter $marketplacePresenter;

    public function __construct(
        CreateMarketplace $createStore,
        MarketplaceRepository $marketplaceRepository,
        MarketplacePresenter $marketplacePresenter
    ) {
        $this->createStore = $createStore;
        $this->marketplaceRepository = $marketplaceRepository;
        $this->marketplacePresenter = $marketplacePresenter;
    }

    public function create(Request $request)
    {
        return view('pages.marketplaces.create');
    }

    public function list(Request $request)
    {
        $marketplaces = $this->marketplaceRepository->list();
        $data = $this->marketplacePresenter->present($marketplaces);

        return view('pages.marketplaces.list', $data);
    }

    public function store(Request $request)
    {
        $this->createStore->create($request->all());

        return redirect()->route('marketplaces.list');
    }
}
