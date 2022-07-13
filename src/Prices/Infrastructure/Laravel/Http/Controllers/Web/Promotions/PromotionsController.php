<?php

namespace Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Promotions;

class PromotionsController
{
    public function index()
    {
        return view('pages.promotions.index');
    }

    public function calculate()
    {
        return view('pages.promotions.calculate-form');
    }
}
