<?php

namespace Src\Users\Infrastructure\Laravel\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Src\Users\Infrastructure\Laravel\Http\Requests\UpdateTaxRateRequest;
use Src\Users\Infrastructure\Laravel\Repositories\Repository;

class TaxesController
{
    public function __construct(
        private Repository $repository
    ) {
    }

    public function get(): View
    {
        $user = auth()->user();

        return view('pages.users.taxes', [
            'taxRate' => $user->getSimplesNacionalTaxRate(),
        ]);
    }

    public function update(UpdateTaxRateRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $this->repository->updateTax($user, $request->getTaxRate());

        return redirect()->back();
    }
}
