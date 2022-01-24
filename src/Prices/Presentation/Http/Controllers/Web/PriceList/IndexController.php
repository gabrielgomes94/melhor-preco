<?php

namespace Src\Prices\Presentation\Http\Controllers\Web\PriceList;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    /**
     * @return Application|ViewFactory|View
     */
    public function index()
    {
        return view('pages.pricing.price-list.index');
    }
}
