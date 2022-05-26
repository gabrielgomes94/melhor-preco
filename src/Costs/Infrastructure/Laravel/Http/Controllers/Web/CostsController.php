<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Src\Costs\Domain\UseCases\Contracts\UpdateCosts;
use Src\Prices\Application\Services\Exceptions\UpdatePriceException;
use Src\Products\Presentation\Http\Requests\Product\UpdateCostsRequest;

class CostsController extends Controller
{
    public function __construct(
        private UpdateCosts $updateService,
    ) {
    }

    public function update(string $productId, UpdateCostsRequest $request)
    {
        try {
            $this->updateService->execute($productId, $request->validated());

            session()->flash('message', "Produto {$productId} teve seu custo atualizado com sucesso.");
        } catch (UpdatePriceException $exception) {
            session()->flash('error', $exception->getMessage());
        }

        return redirect()->back();
    }
}
