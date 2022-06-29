<?php

namespace Src\Prices\Infrastructure\Laravel\Presentation\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    public function index(): Application|ViewFactory|View
    {
        return view('pages.pricing.price-list.index');
    }
}
