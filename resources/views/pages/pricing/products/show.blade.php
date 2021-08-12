<x-layout>

    <div class="container">
        <div class="row">
            <x-utils.breadcrumb :breadcrumb="$breadcrumb" />

            <x-utils.alert-messages />
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <x-pricing.products.update-form :productInfo="$productInfo" />
            </div>
            <div class="col-sm-8">
                <x-pricing.prices.list :prices="$prices" :productId="$productInfo->sku()" />
            </div>
        </div>
    </div>
</x-layout>
