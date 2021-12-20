<x-layout>
    <x-slot name="navbar">
        <x-app.pricing.price-list.navbar :selected="$store->getSlug()"/>
    </x-slot>

    <x-slot name="breadcrumb">
        <x-utils.breadcrumb :breadcrumb="$breadcrumb"/>
    </x-slot>

    <div class="row">
        <x-utils.alert-messages />
    </div>

    <div class="row mb-4">
        <div class="mb-4">
            <h3>{{ $product->getSku() }} - {{ $product->getDetails()->getName() }}</h3>
        </div>

        <div class="col-4">
            <div class="mb-4">
                <x-app.pricing.prices.calculator.card :post="$post" :product="$product" />
            </div>

            <x-app.pricing.prices.update-costs.form :product="$product" />
        </div>

        <div class="col-8">
            <x-app.pricing.prices.price.card :post="$post" :product="$product"  />
        </div>
    </div>
</x-layout>
