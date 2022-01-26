<x-layout>
    <x-slot name="navbar">
        <x-app.pricing.price-list.navbar :selected="$store->getSlug()"/>
    </x-slot>

    <x-slot name="breadcrumb">
        <x-template.breadcrumb.breadcrumb :breadcrumb="$breadcrumb"/>
    </x-slot>

    <div class="row">
        <x-template.alert-messages.alert-messages />
    </div>

    <div class="row mb-4">
        <div class="mb-4">
            <x-template.links.link :route="route('products.reports.show', $product->getSku())">
                <h3>{{ $productHeader }}</h3>
            </x-template.links.link>
        </div>

        <div class="col-4">
            <div class="mb-4">
                <x-app.pricing.prices.calculator.card
                    :price="$price"
                    :product="$product"
                    :store="$store"
                />
            </div>

            <x-app.pricing.prices.update-costs.form :product="$product" />
        </div>

        <div class="col-8">
            @if ($store->getSlug() === 'magalu')
                <x-app.pricing.prices.price.magalu-card
                    :price="$price"
                    :productId="$productId"
                    :store="$store"
                />
            @elseif ($store->getSlug() === 'mercado_livre')
                <x-app.pricing.prices.price.mercado-livre-card
                    :price="$price"
                    :productId="$productId"
                    :store="$store"
                />
            @else
                <x-app.pricing.prices.price.card
                    :price="$price"
                    :product="$product"
                    :productId="$productId"
                    :store="$store"
                />
            @endif
        </div>
    </div>
</x-layout>
