<x-layout>

    <div class="container">
        <div class="row">
            <x-utils.breadcrumb
                :breadcrumb="$breadcrumb"
            >
            </x-utils.breadcrumb>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <x-pricing.products.update-form :productInfo="$productInfo" :pricingId="$pricingId" />
            </div>
            <div class="col-sm-8">
                <x-pricing.prices.list :prices="$prices" :pricingId="$pricingId" :productId="$productInfo->id" />
            </div>
        </div>
    </div>
</x-layout>
