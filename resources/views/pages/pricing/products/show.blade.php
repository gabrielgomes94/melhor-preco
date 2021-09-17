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

    <div class="row">
        <div class="mb-4">
            <h3>{{ $productInfo->sku() }} - {{ $productInfo->name() }}</h3>
        </div>

        <div class="col-sm-4">
            <x-pricing.products.update-form :productInfo="$productInfo" />
        </div>
        <div class="col-sm-8">
            <x-pricing.prices.list :prices="$prices" :productId="$productInfo->sku()" />
        </div>
    </div>
</x-layout>
