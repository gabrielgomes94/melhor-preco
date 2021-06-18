<?php

namespace App\Http\Controllers\Front\Pricing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pricing\Price\UpdatePrice;
use App\Models\Price;
use App\Repositories\Pricing\Price\Updator;
use Integrations\Bling\Products\Clients\ProductStore;

class UpdatePriceController extends Controller
{
    private Updator $repository;
    private ProductStore $client;

    public function __construct(Updator $repository, ProductStore $client)
    {
        $this->repository = $repository;
        $this->client = $client;
    }

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

        return redirect()->route('pricing.show', [
            'pricing_id' => $pricingId,
        ]);
    }
}
