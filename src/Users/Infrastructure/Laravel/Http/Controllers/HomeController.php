<?php

namespace Src\Users\Infrastructure\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;

class HomeController extends Controller
{
    public function __construct(
        private MarketplaceRepository $marketplaceRepository,
    )
    {}

    public function __invoke()
    {
        $userId = $this->getUserId();

        if (count($this->marketplaceRepository->list($userId)) === 0) {
            return redirect()->route('users.settings.integrations');
        }

        return redirect()->route('pricing.priceList.byStore');
    }
}
