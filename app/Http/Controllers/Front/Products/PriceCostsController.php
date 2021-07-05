<?php

namespace App\Http\Controllers\Front\Products;

use App\Http\Controllers\Controller;
use App\Repositories\Product\FinderDB;
use Illuminate\Http\Request;

class PriceCostsController extends Controller
{
    private FinderDB $repository;

    public function __construct(FinderDB $repository)
    {
        $this->repository = $repository;
    }

    public function edit(Request $request)
    {
        $products = $this->repository->all();
//        dd($products[0]);
//        dd('oioioioi');

        return view('pages.products.price_costs.edit', ['products' => $products]);
    }

    public function update(Request $request)
    {
    }
}
