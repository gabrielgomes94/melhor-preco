<?php

namespace Src\Users\Infrastructure\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Src\Users\Infrastructure\Laravel\Http\Requests\UpdateTaxRateRequest;
use Src\Users\Infrastructure\Laravel\Repositories\Repository;

class TaxesController extends Controller
{
    public function __construct(
        private Repository $repository
    ) {
    }

    public function get(): View
    {
        $user = $this->getUser();

        return view('pages.users.taxes', [
            'taxes' => [
                'simplesNacional' => str_replace('.', ',', $user->getSimplesNacionalTaxRate()),
                'icms' => str_replace('.', ',', $user->getIcmsInnerStateTaxRate()),
            ]
        ]);
    }

    public function update(UpdateTaxRateRequest $request): RedirectResponse
    {
        $this->repository->updateTax($this->getUser(), $request->transform());

        return redirect()->back();
    }
}
