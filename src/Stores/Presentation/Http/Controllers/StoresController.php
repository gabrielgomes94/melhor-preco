<?php

namespace Src\Stores\Presentation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Src\Stores\Application\UseCase\CreateStore;

class StoresController extends Controller
{
    private CreateStore $createStore;

    public function __construct(CreateStore $createStore)
    {
        $this->createStore = $createStore;
    }


    public function create(Request $request)
    {
        return view('pages.stores.create');
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $this->createStore->create($request->all());

        dd('oi');
//        return ;
    }
}
