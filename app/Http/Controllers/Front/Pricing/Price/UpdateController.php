<?php

namespace App\Http\Controllers\Front\Pricing\Price;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pricing\Price\UpdatePrice;
use App\Models\Price;
use App\Repositories\Pricing\Price\Updator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Integrations\Bling\Products\Clients\ProductStore;

class UpdateController extends Controller
{
    private Updator $repository;
    private ProductStore $client;

    public function __construct(Updator $repository, ProductStore $client)
    {
        $this->repository = $repository;
        $this->client = $client;
    }

    /**
     * @return Redirector|RedirectResponse
     */
    public function update(string $pricingId, string $productId, string $priceId, UpdatePrice $request)
    {
        $this->repository->update($priceId, $request->validated());

        $price = Price::find($priceId);

        $this->client->update(
            $productId,
            $request->input('storeSlug'),
            $price->store_sku_id,
            $request->input('value')
        );

        return redirect()->route('pages.pricing.show', [
            'id' => $pricingId,
        ]);
    }
}
