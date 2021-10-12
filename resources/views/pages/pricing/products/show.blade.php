<x-layout>
    <x-slot name="navbar">
        <x-pricing.price-list.navbar :selected="$store->slug()"/>
    </x-slot>

    <x-slot name="breadcrumb">
        <x-utils.breadcrumb :breadcrumb="$breadcrumb"/>
    </x-slot>

    <div class="row">
        <x-utils.alert-messages />
    </div>

    <div class="row mb-4">
        <div class="mb-4">
            <h3>{{ $price->product()->sku() }} - {{ $price->product()->name() }}</h3>
        </div>

        <div class="col-4">
            <div class="mb-4">
                <x-pricing.prices.calculator.card :price="$price" :productId="$price->product()->sku()" />
            </div>

            <x-pricing.prices.update-costs.form :product="$price->product()" />
        </div>

        <div class="col-8">
            <x-pricing.prices.price.card :price="$price" :productId="$price->product()->sku()" />
        </div>
    </div>
</x-layout>
