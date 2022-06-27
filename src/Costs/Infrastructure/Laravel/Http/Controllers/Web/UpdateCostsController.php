<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Src\Costs\Domain\Exceptions\UpdateCostsException;
use Src\Costs\Domain\UseCases\Contracts\UpdateCosts;
use Src\Costs\Infrastructure\Laravel\Http\Requests\UpdateCostsRequest;
use Src\Products\Domain\Exceptions\ProductNotFoundException;

class UpdateCostsController extends Controller
{
    public function __construct(
        private UpdateCosts $updateService,
    ) {
    }

    public function __invoke(string $productId, UpdateCostsRequest $request)
    {
        try {
            $this->updateService->execute($productId, $request->validated());

            session()->flash('message', "Produto {$productId} teve seu custo atualizado com sucesso.");
        } catch (ProductNotFoundException $exception) {
            session()->flash('error', $exception->getMessage());
        } catch (UpdateCostsException $exception) {
            session()->flash('error', $exception->getMessage());
        }

        return redirect()->back();
    }
}
