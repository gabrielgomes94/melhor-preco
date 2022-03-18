<?php

namespace Src\Promotions\Presentation\Http\Controllers;

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
