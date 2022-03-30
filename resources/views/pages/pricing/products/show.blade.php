<x-layout>
    <x-slot name="navbar">
        <x-app.pricing.price-list.navbar :selected="$store->getSlug()" :marketplaces="$marketplaces"/>
    </x-slot>

    <x-slot name="breadcrumb">
        <x-bootstrap.breadcrumb.breadcrumb :breadcrumb="$breadcrumb"/>
    </x-slot>

    <div class="row">
        <x-bootstrap.alert-messages.alert-messages />
    </div>

    <div class="row mb-4">
        <div class="mb-4">
            <x-bootstrap.links.link :route="route('products.reports.show', $product->getSku())">
                <h3>{{ $productHeader }}</h3>
            </x-bootstrap.links.link>
        </div>

        <div class="col-4">
            <div class="mb-4">
                <x-app.pricing.prices.calculator.card
                    :price="$price"
                    :product="$product"
                    :store="$store"
                    :isFreeFreightDisabled="$isFreeFreightDisabled"
                />
            </div>

            <x-app.pricing.prices.update-costs.form :product="$product" />
        </div>

        <div class="col-8">
            <x-app.pricing.prices.price.card
                :price="$price"
                :product="$product"
                :productId="$productId"
                :store="$store"
            />
        </div>
    </div>
</x-layout>
