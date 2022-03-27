<?php

namespace Src\Promotions\Infrastructure\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use Src\Promotions\Domain\UseCases\CalculatePromotions;
use Src\Promotions\Infrastructure\Laravel\Http\Requests\CalculatePromotionRequest;

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
