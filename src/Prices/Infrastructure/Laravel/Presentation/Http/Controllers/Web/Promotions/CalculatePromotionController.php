<?php

namespace Src\Prices\Infrastructure\Laravel\Presentation\Http\Controllers\Web\Promotions;

use App\Http\Controllers\Controller;
use Src\Prices\Infrastructure\Laravel\Presentation\Http\Requests\Promotions\CalculatePromotionRequest;
use Src\Prices\Infrastructure\Laravel\Services\Promotions\CalculatePromotions;

class CalculatePromotionController extends Controller
{
    public function __construct(
        private CalculatePromotions $calculatePromotions
    ) {}

    public function __invoke(CalculatePromotionRequest $request)
    {
        $data = $request->transform();
        $this->calculatePromotions->calculate($data);

        return redirect()->route('promotions.index');
    }
}
